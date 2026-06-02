# ============================================================
# RDS サブネットグループ
# - プライベートサブネット2つを束ねたもの
# - RDSはこのグループ内のどこかに配置される
# - Multi-AZにする場合も、このグループの中で別AZにスタンバイが立つ
# ============================================================
resource "aws_db_subnet_group" "main" {
    name       = "fameal-db-subnet-group"
    subnet_ids = aws_subnet.private[*].id

    tags = {
        Name = "fameal-db-subnet-group"
    }
}

# ============================================================
# ランダムパスワード生成
# - 32文字、英数記号
# - terraform apply のたびに再生成されないよう keepers で固定
# ============================================================
resource "random_password" "db" {
    length  = 32
    special = true
    # RDS で使えない文字を除外(@ / " など)
    override_special = "!#$%&*()-_=+[]{}<>:?"
}

# ============================================================
# Secrets Manager: DB認証情報の保管
# ============================================================
resource "aws_secretsmanager_secret" "db" {
    name                    = "fameal/db/credentials"
    description             = "Fameal DB master credentials"
    recovery_window_in_days = 0  # 学習用: 即削除可能。本番は7〜30日

    tags = {
        Name = "fameal-db-secret"
    }
}

resource "aws_secretsmanager_secret_version" "db" {
    secret_id = aws_secretsmanager_secret.db.id
    secret_string = jsonencode({
        username = "fameal"
        password = random_password.db.result
    })
}

# ============================================================
# RDS インスタンス (PostgreSQL)
# ============================================================
resource "aws_db_instance" "main" {
    identifier = "fameal-db"

    # エンジン
    engine         = "postgres"
    engine_version = "16.6"
    instance_class = "db.t3.micro"

    # ストレージ
    allocated_storage     = 20
    max_allocated_storage = 100  # オートスケーリング上限
    storage_type          = "gp3"
    storage_encrypted     = true

    # データベース設定
    db_name  = "fameal"
    username = "fameal"
    password = random_password.db.result

    # ネットワーク
    db_subnet_group_name   = aws_db_subnet_group.main.name
    vpc_security_group_ids = [aws_security_group.rds.id]
    publicly_accessible    = false  # プライベートサブネット内、外部公開なし

    # 可用性(学習用は Single-AZ)
    multi_az = false

    # バックアップ
    backup_retention_period = 1     # 学習用: 1日。本番は7〜30
    backup_window           = "16:00-17:00"  # UTC、日本時間 01:00-02:00

    # メンテナンス
    maintenance_window      = "sun:17:00-sun:18:00"  # UTC、日本時間 日 02:00-03:00
    auto_minor_version_upgrade = true

    # 削除関連(学習用設定)
    skip_final_snapshot       = true   # destroy時にスナップショット取らない
    delete_automated_backups  = true   # 自動バックアップも削除
    deletion_protection       = false  # 削除保護OFF

    tags = {
        Name = "fameal-db"
    }
}
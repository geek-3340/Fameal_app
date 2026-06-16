# ーーーーーーーーーーーーーーーーーーーー
# EC2用セキュリティグループ
# ーーーーーーーーーーーーーーーーーーーー

# SG本体の宣言
resource "aws_security_group" "ec2" {
    name        = "${var.project}-ec2-sg"
    description = "Fameal EC2: allow HTTP and SSH"
    vpc_id      = aws_vpc.main.id # ここで宣言したVPCで使用できる
    tags        = { Name = "${var.project}-ec2-sg" }
}

# 以下の３つのResourceでSGが許可する通信を宣言
resource "aws_vpc_security_group_ingress_rule" "ec2_http" {
    security_group_id = aws_security_group.ec2.id
    description       = "HTTP from anywhere"
    cidr_ipv4         = "0.0.0.0/0" # インターネットからの
    from_port         = 80          # 80ポートから
    to_port           = 80          # 80ポートまで（=80ポート（HTTP通信のみ））
    ip_protocol       = "tcp"
    # つまり全てのIPアドレス＝インターネットからのHTTP＝80ポートからの侵入=ingressを許可する
}

resource "aws_vpc_security_group_ingress_rule" "ec2_ssh" {
    security_group_id = aws_security_group.ec2.id
    description       = "SSH from my IP"
    cidr_ipv4         = var.my_ip_cidr # 自分のパブリックIP：variables.tfで宣言→terraform.tfvarsで値を代入したものを参照してる
    from_port         = 22
    to_port           = 22
    ip_protocol       = "tcp"
    # 自分のパブリックIPからのSSH＝22ポートからの侵入=ingressを許可する
}

resource "aws_vpc_security_group_egress_rule" "ec2_all" {
    security_group_id = aws_security_group.ec2.id
    description       = "All outbound"
    cidr_ipv4         = "0.0.0.0/0"
    ip_protocol       = "-1" # 全プロトコル。-1のときはポートを書かない
    # 全てのIPアドレス＝インターネットかつ全ポートへ出て行く=egressことを許可する
}

# ーーーーーーーーーーーーーーーーーーーー
# RDS用セキュリティグループ
# ーーーーーーーーーーーーーーーーーーーー

resource "aws_security_group" "rds" {
    name        = "${var.project}-rds-sg"
    description = "Fameal RDS: allow 5432 from EC2 SG only"
    vpc_id      = aws_vpc.main.id
    tags        = { Name = "${var.project}-rds-sg" }
}

resource "aws_vpc_security_group_ingress_rule" "rds_from_ec2" {
    security_group_id            = aws_security_group.rds.id
    description                  = "PostgreSQL from EC2 SG"
    referenced_security_group_id = aws_security_group.ec2.id # cidrの代わりにSGを指定（ここでは上記のec2のSG）
    from_port                    = 5432 # 5432=PostgreSQLのポート番号
    to_port                      = 5432
    ip_protocol                  = "tcp"
    # 指定したSGが付与されたリソースからの5432ポートの通信の侵入を許可
    # egressを宣言しない=「EC2 → RDS の5432を許可」とだけ書けば、RDSからEC2への応答は自動で通る（ステートフル）
}

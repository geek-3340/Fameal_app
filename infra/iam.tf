# ============================================================
# EC2 用 IAM ロール
# - EC2インスタンスがAWSサービスを呼び出すための権限
# ============================================================
resource "aws_iam_role" "ec2" {
    name = "fameal-ec2-role"

    # 信頼ポリシー: 「EC2サービスがこのロールを引き受けてよい」
    assume_role_policy = jsonencode({
        Version = "2012-10-17"
        Statement = [{
        Effect = "Allow"
        Principal = {
            Service = "ec2.amazonaws.com"
        }
        Action = "sts:AssumeRole"
        }]
    })

    tags = {
        Name = "fameal-ec2-role"
    }
}

# ============================================================
# Secrets Manager の DB シークレット読み取り権限
# ============================================================
resource "aws_iam_role_policy" "ec2_secrets" {
    name = "fameal-ec2-secrets-policy"
    role = aws_iam_role.ec2.id

    policy = jsonencode({
        Version = "2012-10-17"
        Statement = [{
        Effect = "Allow"
        Action = [
            "secretsmanager:GetSecretValue",
            "secretsmanager:DescribeSecret"
        ]
        Resource = aws_secretsmanager_secret.db.arn
        }]
    })
}

# ============================================================
# インスタンスプロファイル (ロールを EC2 に付けるための入れ物)
# ============================================================
resource "aws_iam_instance_profile" "ec2" {
    name = "fameal-ec2-profile"
    role = aws_iam_role.ec2.name
}
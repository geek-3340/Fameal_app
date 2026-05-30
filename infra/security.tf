# ============================================================
# EC2 用セキュリティグループ
# - HTTP 80 を全世界から許可
# - SSH 22 を全世界から許可(学習用、本来は自分のIPに絞る)
# ============================================================
resource "aws_security_group" "ec2" {
  name        = "fameal-ec2-sg"
  description = "Security group for Fameal EC2"
  vpc_id      = aws_vpc.main.id

  tags = {
    Name = "fameal-ec2-sg"
  }
}

resource "aws_vpc_security_group_ingress_rule" "ec2_http" {
  security_group_id = aws_security_group.ec2.id
  cidr_ipv4         = "0.0.0.0/0"
  from_port         = 80
  to_port           = 80
  ip_protocol       = "tcp"
  description       = "HTTP from anywhere"
}

resource "aws_vpc_security_group_ingress_rule" "ec2_ssh" {
  security_group_id = aws_security_group.ec2.id
  cidr_ipv4         = "0.0.0.0/0"
  from_port         = 22
  to_port           = 22
  ip_protocol       = "tcp"
  description       = "SSH from anywhere"
}

resource "aws_vpc_security_group_egress_rule" "ec2_all" {
  security_group_id = aws_security_group.ec2.id
  cidr_ipv4         = "0.0.0.0/0"
  ip_protocol       = "-1"
  description       = "Allow all outbound"
}

# ============================================================
# RDS 用セキュリティグループ
# - PostgreSQL 5432 を EC2 用 SG からのみ許可(SG参照)
# - Day 6 で RDS を作るときに使う、今は箱だけ
# ============================================================
resource "aws_security_group" "rds" {
    name        = "fameal-rds-sg"
    description = "Security group for Fameal RDS"
    vpc_id      = aws_vpc.main.id

    tags = {
        Name = "fameal-rds-sg"
    }
}

resource "aws_vpc_security_group_ingress_rule" "rds_from_ec2" {
    security_group_id            = aws_security_group.rds.id
    referenced_security_group_id = aws_security_group.ec2.id
    from_port                    = 5432
    to_port                      = 5432
    ip_protocol                  = "tcp"
    description                  = "PostgreSQL from EC2 SG"
}

resource "aws_vpc_security_group_egress_rule" "rds_all" {
    security_group_id = aws_security_group.rds.id
    cidr_ipv4         = "0.0.0.0/0"
    ip_protocol       = "-1"
    description       = "Allow all outbound"
}
# ============================================================
# データソース: 最新の Ubuntu 24.04 LTS AMI を取得
# ============================================================
data "aws_ami" "ubuntu" {
    most_recent = true
    owners      = ["099720109477"]  # Canonical 公式

    filter {
        name   = "name"
        values = ["ubuntu/images/hvm-ssd-gp3/ubuntu-noble-24.04-amd64-server-*"]
    }

    filter {
        name   = "virtualization-type"
        values = ["hvm"]
    }
}

# ============================================================
# EC2 インスタンス
# - t3.micro, Ubuntu 24.04
# - パブリックサブネット1(1a) に配置
# - SSH キーペアは Week 2 で作ったものを使う(後述)
# ============================================================
resource "aws_instance" "app" {
    ami                    = data.aws_ami.ubuntu.id
    instance_type          = "t3.micro"
    subnet_id              = aws_subnet.public[0].id
    vpc_security_group_ids = [aws_security_group.ec2.id]
    key_name               = var.ec2_key_name

    root_block_device {
        volume_size = 8
        volume_type = "gp3"
    }

    tags = {
        Name = "fameal-ec2"
    }
}

# ============================================================
# Elastic IP
# ============================================================
resource "aws_eip" "app" {
    domain   = "vpc"

    tags = {
        Name = "fameal-eip"
    }
    }

    resource "aws_eip_association" "app" {
    instance_id   = aws_instance.app.id
    allocation_id = aws_eip.app.id
}
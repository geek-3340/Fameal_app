# ーーーーーーーーーーーーーーーーーーーー
# AWSに公開鍵を登録
# ーーーーーーーーーーーーーーーーーーーー
resource "aws_key_pair" "fameal" {
    key_name   = var.key_name
    public_key = file(pathexpand(var.public_key_path))
}

# ーーーーーーーーーーーーーーーーーーーー
# データソースでAMIを取得
# ーーーーーーーーーーーーーーーーーーーー
data "aws_ami" "ubuntu" {
    most_recent = true
    owners      = ["099720109477"] # Canonical（Ubuntu公式）

    filter {
        name   = "name"
        values = ["ubuntu/images/hvm-ssd-gp3/ubuntu-noble-24.04-amd64-server-*"]
    }
    filter {
        name   = "virtualization-type"
        values = ["hvm"]
    }
}

# ーーーーーーーーーーーーーーーーーーーー
# EC2本体
# ーーーーーーーーーーーーーーーーーーーー
resource "aws_instance" "fameal" {
    ami                    = data.aws_ami.ubuntu.id
    instance_type          = "t3.micro"
    subnet_id              = aws_subnet.public["1a"].id
    vpc_security_group_ids = [aws_security_group.ec2.id]
    key_name               = aws_key_pair.fameal.key_name

    root_block_device {
        volume_size           = 20
        volume_type           = "gp3"
        delete_on_termination = true
        encrypted             = true
    }

    metadata_options {
        http_endpoint = "enabled"
        http_tokens   = "required"   # IMDSv2を強制（SSRF対策）
    }

    credit_specification {
        cpu_credits = "standard"     # バースト課金を防ぐ
    }

    tags = { Name = "${var.project}-ec2" }
}

# ーーーーーーーーーーーーーーーーーーーー
# ElasticIP
# ーーーーーーーーーーーーーーーーーーーー
resource "aws_eip" "fameal" {
    domain     = "vpc"
    depends_on = [aws_internet_gateway.main]
    tags       = { Name = "${var.project}-eip" }
}

resource "aws_eip_association" "fameal" {
    instance_id   = aws_instance.fameal.id
    allocation_id = aws_eip.fameal.id
}
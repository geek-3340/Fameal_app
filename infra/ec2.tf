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
    iam_instance_profile   = aws_iam_instance_profile.ec2.name # 追加

    user_data = <<-EOF
        #!/bin/bash
        set -e
        
        # システムパッケージ更新
        apt-get update
        apt-get install -y software-properties-common ca-certificates curl gnupg lsb-release unzip
        
        # PHP 8.3 リポジトリ追加
        add-apt-repository -y ppa:ondrej/php
        apt-get update
        
        # PHP 8.3 と必要な拡張
        apt-get install -y \
        php8.3-fpm php8.3-cli php8.3-pgsql php8.3-mbstring \
        php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd \
        php8.3-intl
        
        # Composer
        curl -sS https://getcomposer.org/installer | php
        mv composer.phar /usr/local/bin/composer
        
        # Node.js 20
        curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
        apt-get install -y nodejs
        
        # Nginx
        apt-get install -y nginx
        
        # PostgreSQL クライアント (psql 動作確認用)
        apt-get install -y postgresql-client
        
        # アプリ配置ディレクトリ
        mkdir -p /var/www
        chown -R ubuntu:ubuntu /var/www
        
        # 完了マーカー
        touch /var/log/fameal-userdata-done
    EOF

    user_data_replace_on_change = false

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
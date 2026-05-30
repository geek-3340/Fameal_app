# ============================================================
# データソース: 東京リージョンの利用可能なAZ一覧を取得
# ============================================================
data "aws_availability_zones" "available" {
    state = "available"
}

# ============================================================
# VPC本体
# ============================================================
resource "aws_vpc" "main" {
    cidr_block           = "10.0.0.0/16"
    enable_dns_support   = true
    enable_dns_hostnames = true

    tags = {
        Name = "fameal-vpc"
    }
}

# ============================================================
# インターネットゲートウェイ
# ============================================================
resource "aws_internet_gateway" "main" {
    vpc_id = aws_vpc.main.id

    tags = {
        Name = "fameal-igw"
    }
}

# ============================================================
# パブリックサブネット x 2 (10.0.1.0/24, 10.0.2.0/24)
# ============================================================
resource "aws_subnet" "public" {
    count                   = 2
    vpc_id                  = aws_vpc.main.id
    cidr_block              = "10.0.${count.index + 1}.0/24"
    availability_zone       = data.aws_availability_zones.available.names[count.index]
    map_public_ip_on_launch = true

    tags = {
        Name = "fameal-subnet-public-${count.index + 1}"
    }
}

# ============================================================
# プライベートサブネット x 2 (10.0.11.0/24, 10.0.12.0/24)
# ============================================================
resource "aws_subnet" "private" {
    count             = 2
    vpc_id            = aws_vpc.main.id
    cidr_block        = "10.0.${count.index + 11}.0/24"
    availability_zone = data.aws_availability_zones.available.names[count.index]

    tags = {
        Name = "fameal-subnet-private-${count.index + 1}"
    }
}

# ============================================================
# ルートテーブル(パブリック用)
# ============================================================
resource "aws_route_table" "public" {
    vpc_id = aws_vpc.main.id

    route {
        cidr_block = "0.0.0.0/0"
        gateway_id = aws_internet_gateway.main.id
    }

    tags = {
        Name = "fameal-rt-public"
    }
}

# ============================================================
# ルートテーブル(プライベート用): localのみ、追加ルートなし
# ============================================================
resource "aws_route_table" "private" {
    vpc_id = aws_vpc.main.id

    tags = {
        Name = "fameal-rt-private"
    }
}

# ============================================================
# ルートテーブルとサブネットの関連付け
# ============================================================
resource "aws_route_table_association" "public" {
    count          = 2
    subnet_id      = aws_subnet.public[count.index].id
    route_table_id = aws_route_table.public.id
}

resource "aws_route_table_association" "private" {
    count          = 2
    subnet_id      = aws_subnet.private[count.index].id
    route_table_id = aws_route_table.private.id
}
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# Data source
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
/*
data（データソース）は「作る」ものではなく「既にある情報を読み取る」ブロック
ここでは「今このリージョンで使えるAZの一覧」をAWSに問い合わせる
AZの宣言に使う変数として利用する
*/
data "aws_availability_zones" "available" {
    state = "available" # ←定石：impaired（障害中）やunavailableを除外して、今使えるAZだけ
}


# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# VPC
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
resource "aws_vpc" "main" {
    cidr_block = var.vpc_cidr

    /*
    EC2にパブリックDNS名を自動で付けるか。
    デフォルトはfalse。(省略可)
    本番VPCではtrueにして明示的に書く項目。
    */
    enable_dns_hostnames = true

    tags = {
    Name = "fameal-test-vpc"
    }

    # 以下はデフォルト値のため、書かなくても可

    /*
    VPC内のEC2を物理サーバーで共有するか専有するか。
    defaultは共有（普通の使い方）。
    専有(dedicated)は超高額なので、書かない＝共有で正解。
    */
    instance_tenancy = "default"

    /*
    VPC内でAWSのDNS名前解決を使えるか。
    デフォルトで有効。
    RDSのエンドポイント名などを解決するのに必要なので、trueでOK。
    */
    enable_dns_support = true

    /*
    IPv6を使うか。今回IPv4だけなのでfalseで問題なし。
    */
    assign_generated_ipv6_cidr_block = false
}


# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# Subnet
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

# for_eachで複数のサブネットを宣言するための変数定義
locals {
    public_subnets = {
        "1a" = { cidr = "10.0.1.0/24", az = "ap-northeast-1a" }
        "1c" = { cidr = "10.0.2.0/24", az = "ap-northeast-1c" }
    }
    private_subnets = {
        "1a" = { cidr = "10.0.11.0/24", az = "ap-northeast-1a" }
        "1c" = { cidr = "10.0.12.0/24", az = "ap-northeast-1c" }
    }
}

resource "aws_subnet" "public" {
    for_each          = local.public_subnets
    vpc_id            = aws_vpc.main.id
    cidr_block        = each.value.cidr
    availability_zone = each.value.az
    map_public_ip_on_launch = true # サブネット内のリソースにパブリックIPを通す（デフォルトはfalse）
    tags = { Name = "${var.project}-public-${each.key}" }
}

resource "aws_subnet" "private" {
    for_each          = local.private_subnets
    vpc_id            = aws_vpc.main.id
    cidr_block        = each.value.cidr
    availability_zone = each.value.az
    # map_public_ip_on_launch：privateサブネットはパブリックIPに接続されるべきではない為、省略（=デフォルトのfalse）
    tags = { Name = "${var.project}-private-${each.key}" }
}


# countとdata sourceでの宣言ver.
# resource "aws_subnet" "public" {
#     count                   = 2
#     vpc_id                  = aws_vpc.main.id
#     cidr_block              = "10.0.${count.index + 1}.0/24"
#     availability_zone       = data.aws_availability_zones.available.names[count.index]
#     map_public_ip_on_launch = true

#     tags = {
#         Name = "${var.project}-public-${count.index}"
#     }
# }

# resource "aws_subnet" "private" {
#     count             = 2
#     vpc_id            = aws_vpc.main.id
#     cidr_block        = "10.0.${count.index + 11}.0/24"
#     availability_zone = data.aws_availability_zones.available.names[count.index]

#     tags = {
#         Name = "${var.project}-private-${count.index}"
#     }
# }


# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# IGW - Internet Gate Way
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
resource "aws_internet_gateway" "main" {
    vpc_id = aws_vpc.main.id

    tags = {
        Name = "${var.project}-igw"
    }
}


# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# Route Table
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
resource "aws_route_table" "public" {
    vpc_id = aws_vpc.main.id

    /*
    localルート＝VPCのCIDR（10.0.0.0/16）宛て＝「VPC内部宛て」
    のルートは書かない！
    どのルートテーブルにもAWSによって自動で必ず付くから！

    privateのルートテーブルは route ブロックを一切書かなくても
    「VPC内部の通信だけは通る・外には出られない」状態となる
    */
    route {
        cidr_block = "0.0.0.0/0" # すべての宛先を意味する（=インタネットへ出ていける）
        gateway_id = aws_internet_gateway.main.id # IGWに通す
    }

    tags = {
        Name = "${var.project}-rt-public"
    }
}

resource "aws_route_table" "private" {
    vpc_id = aws_vpc.main.id

    tags = {
        Name = "${var.project}-rt-private"
    }
}

# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
# RT Association
# ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
resource "aws_route_table_association" "public" {
    for_each       = aws_subnet.public
    subnet_id      = each.value.id
    route_table_id = aws_route_table.public.id
}

resource "aws_route_table_association" "private" {
    for_each       = aws_subnet.private
    subnet_id      = each.value.id
    route_table_id = aws_route_table.private.id
}
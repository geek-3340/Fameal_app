output "vpc_id" {
    description = "作成したVPCのID"
    value       = aws_vpc.main.id
}

output "public_subnet_ids" {
    description = "パブリックサブネットのID一覧"
    value       = aws_subnet.public[*].id
}

output "private_subnet_ids" {
    description = "プライベートサブネットのID一覧"
    value       = aws_subnet.private[*].id
}

output "igw_id" {
    description = "インターネットゲートウェイのID"
    value       = aws_internet_gateway.main.id
}
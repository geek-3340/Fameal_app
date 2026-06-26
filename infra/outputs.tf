output "vpc_id" {
    description = "作成したVPCのID"
    value       = aws_vpc.main.id
}

output "public_subnet_ids" {
    description = "パブリックサブネットのID一覧"
    value = values(aws_subnet.public)[*].id
}

output "private_subnet_ids" {
    description = "プライベートサブネットのID一覧"
    value       = values(aws_subnet.private)[*].id
}

output "igw_id" {
    description = "インターネットゲートウェイのID"
    value       = aws_internet_gateway.main.id
}

output "ec2_public_ip" {
    description = "EC2のElastic IP"
    value       = aws_eip.fameal.public_ip
}

output "ec2_instance_id" {
    description = "EC2インスタンスID（後でSSM/SSHに使う）"
    value       = aws_instance.fameal.id
}

output "ami_id" {
    description = "選ばれたUbuntu AMIのID"
    value       = data.aws_ami.ubuntu.id
}
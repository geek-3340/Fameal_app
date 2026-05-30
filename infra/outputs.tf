output "ec2_public_ip" {
    description = "EC2 public IP (Elastic IP)"
    value       = aws_eip.app.public_ip
}

output "ec2_instance_id" {
    description = "EC2 instance ID"
    value       = aws_instance.app.id
}
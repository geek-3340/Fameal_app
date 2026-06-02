output "ec2_public_ip" {
    description = "EC2 public IP (Elastic IP)"
    value       = aws_eip.app.public_ip
}

output "ec2_instance_id" {
    description = "EC2 instance ID"
    value       = aws_instance.app.id
}

output "rds_endpoint" {
    description = "RDS endpoint (hostname:port)"
    value       = aws_db_instance.main.endpoint
}

output "rds_secret_arn" {
    description = "Secrets Manager ARN for DB credentials"
    value       = aws_secretsmanager_secret.db.arn
}
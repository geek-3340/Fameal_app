variable "project" {
    description = "リソース名のプレフィックスに使うプロジェクト名"
    type = string
    default = "fameal"
}

variable "vpc_cidr" {
    description = "VPCのCIDR範囲"
    type = string
    default = "10.0.0.0/16"
}

# 値（default）はterraform.tfvarsで代入する
variable "my_ip_cidr" {
    description = "SSHを許可する自分のIP（例: 203.0.113.4/32）"
    type        = string
}

variable "key_name" {
    description = "EC2に登録するキーペア名"
    type        = string
    default     = "fameal-key-tf"   # Week2のキー名と被らない名前にする
}

variable "public_key_path" {
    description = "登録する公開鍵のパス"
    type        = string
    default     = "~/.ssh/aws-fameal.pub"
}
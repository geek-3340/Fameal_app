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
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
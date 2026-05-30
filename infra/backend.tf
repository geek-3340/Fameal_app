terraform {
    required_version = ">= 1.6.0" # バージョンの下限

    required_providers { # 使用するプロバイダー（AWS,Azure,GoogleCloudなど）の宣言
        aws = {
            source  = "hashicorp/aws"
            version = "~> 5.0" # AWSプロバイダーのv5系を使用
        }
    }

    backend "s3" { # StateをS3に置くという宣言
        bucket         = "fameal-tfstate-316704942673"
        key            = "fameal/terraform.tfstate"
        region         = "ap-northeast-1"
        encrypt        = true # 暗号化をする設定
        use_lockfile   = true # コンフリクト防止用のロックファイルを有効
    }
}

# Terraformの設定（）
terraform {
    required_version = ">= 1.11" # Terraformのバージョン：stateロック用のuse_lockfileに1.11以上が必要なため

    # どのプロバイダーを使うかの宣言
    required_providers {
        aws = {
            source  = "hashicorp/aws" # HASHICORP公式のAWSプロバイダー
            version = "~> 5.0" # 5.x系の最新を使う（5.99まではOK、6.0には上がらない）」という意味：メジャーバージョンを越えての破壊的変更を避けるため
        }
    }
}
/* 補足
なぜ terraform {} ブロックが providers.tf と backend.tf に分かれて2個あるの？と思うかもしれません。
Terraformは複数ファイルの terraform ブロックを自動でマージしてくれるので、役割ごとにファイルを分けて書けます。
「バージョン宣言」と「state保存先」は関心が違うので分けておくと読みやすい、というだけです。
*/

# プロバイダーの設定
provider "aws" {
    region = "ap-northeast-1"

    # このプロバイダで作る全リソースに自動で付くタグ
    default_tags {
        tags = {
        Project   = "fameal"
        ManagedBy = "terraform"
        }
    }
}

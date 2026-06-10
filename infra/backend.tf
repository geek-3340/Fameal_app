terraform {
    # 「stateをS3に保存する」という宣言
    backend "s3" {
        bucket       = "fameal-tfstate-316704942673"   # ← あなたが作ったバケット名に変更
        key          = "fameal/terraform.tfstate" # バケット内のどのパスにstateファイルを置くか
        region       = "ap-northeast-1" # バケットのあるリージョン
        encrypt      = true # stateをS3に書くとき暗号化
        use_lockfile = true # stateをロックする
    }
}
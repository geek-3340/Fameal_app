```bash
terraform fmt        # インデント整形（差分が出たら整形された証拠）
terraform validate   # 構文チェック（AWSには接続しない）
terraform plan       # 何が作られるか事前確認
terraform apply      # 宣言道理にリソースを立ち上げる
terraform destroy    # 全リソースを停止・削除
```
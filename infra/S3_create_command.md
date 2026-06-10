```bash
# 自分のAWSアカウントIDを取得
ACCOUNT_ID=$(aws sts get-caller-identity --query Account --output text)

# 変数に入れておく（以降のコマンドで使い回す）
BUCKET="myapp-tfstate-${ACCOUNT_ID}"
REGION="ap-northeast-1"

# 確認。myapp-tfstate-123456789012 のように出る
echo "$BUCKET $REGION"
myapp-tfstate-123456789012 ap-northeast-1

# バケットを作成(--create-bucket~~はus-east-1以外のリージョンは必須)
aws s3api create-bucket \
  --bucket "$BUCKET" \
  --region "$REGION" \
  --create-bucket-configuration LocationConstraint="$REGION"

# 出力（バケット作成完了）
{
    "Location": "http://myapp-tfstate-123456789012.s3.amazonaws.com/",
    "BucketArn": "arn:aws:s3:::myapp-tfstate-123456789012"
}

# バージョニングを有効化
aws s3api put-bucket-versioning \
  --bucket "$BUCKET" \
  --versioning-configuration Status=Enabled

# パブリックアクセスを全ブロック（デフォルトだが念のため）
aws s3api put-public-access-block \
  --bucket "$BUCKET" \
  --public-access-block-configuration \
    BlockPublicAcls=true,IgnorePublicAcls=true,BlockPublicPolicy=true,RestrictPublicBuckets=true

# 暗号化を明示（デフォルトだが念のため）
aws s3api put-bucket-encryption \
  --bucket "$BUCKET" \
  --server-side-encryption-configuration '{
    "Rules": [{
      "ApplyServerSideEncryptionByDefault": { "SSEAlgorithm": "AES256" },
      "BucketKeyEnabled": true
    }]
  }'

#設定の反映を確認
aws s3api get-bucket-versioning --bucket "$BUCKET"
# → { "Status": "Enabled" } が返ればOK
{
    "Status": "Enabled"
}

aws s3api get-public-access-block --bucket "$BUCKET"
# → 4つとも true が返ればOK
{
    "PublicAccessBlockConfiguration": 
    {
        "BlockPublicAcls": true,
        "IgnorePublicAcls": true,
        "BlockPublicPolicy": true,
        "RestrictPublicBuckets": true
    }
}

aws s3api get-bucket-encryption --bucket "$BUCKET"
# → AES256 が返ればOK
{
    "ServerSideEncryptionConfiguration": 
    {
        "Rules": 
        [
            {
                "ApplyServerSideEncryptionByDefault": {
                    "SSEAlgorithm": "AES256"
                },
                "BucketKeyEnabled": true,
                "BlockedEncryptionTypes": {
                    "EncryptionType": [
                        "SSE-C"
                    ]
                }
            }
        ]
    }
}
```
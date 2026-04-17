# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## コマンド

```bash
# 開発サーバー起動（PHP + Queue + Pail + Vite を同時起動）
composer dev

# テスト実行
composer test

# PHPコードのリント
./vendor/bin/pint

# フロントエンドビルド
npm run build

# データベースマイグレーション
php artisan migrate
```

## アーキテクチャ

**Fameal** は日本の家庭向け食事管理・買い物リスト生成アプリ（乳幼児の離乳食対応）。Laravel 12 + Blade + Alpine.js のフルスタック構成。

### レイヤー構成

**Service + Repository パターン**を採用：

- `app/Http/Controllers/` — HTTPリクエストを受け取り、Serviceに委譲
- `app/Services/` — ビジネスロジック（`MenusService`, `ShoppingListService` など）
- `app/Repositories/` — データアクセス抽象化（`MenusRepository` など）
- `app/Models/` — Eloquent ORM モデル

### コアドメインモデル

- `User` → `Dishes`（料理レシピ）、`Menus`（日付ベースの献立）
- `Menus` ←→ `Dishes`：`MenusDishes`（中間テーブル、`gram`カラムで分量管理）
- `Ingredients` — 料理の材料
- `ShoppingList` — 献立から自動生成される買い物リスト
- `Master*`（`MasterRecipe`, `MasterIngredient`, `MasterBabyFood`）— 参照データ

### フロントエンド

- **Alpine.js** モジュールが `resources/js/modules/` に分割配置（フォーム送信、オートコンプリート、ナビゲーション等）
- **FullCalendar** で献立カレンダーUI を構築
- **Tailwind CSS**（カスタムカラー：gold `#ffb700`、green `#91ff00`、red `#ff7d55`）
- Vite でビルド、Blade テンプレートで描画（SPA ではない）

### API

`/search/recipes`、`/search/babyfoods`、`/search/ingredients` — オートコンプリート用の最小REST API（`app/Http/Controllers/Api/SearchController.php`）

### インフラ

- **PostgreSQL**（セッション・キュー・キャッシュもDB使用）
- **Fly.io** へ自動デプロイ（`main` ブランチへのpushで`.github/workflows/fly-deploy.yml`が実行）
- 本番URL: https://fameal-app.fly.dev/

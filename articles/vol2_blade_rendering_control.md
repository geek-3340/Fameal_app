---
title: 【初めての開発vol.2】　Bladeでルートに応じた画面の描画を制御する
tags: Laravel blade アプリ開発
author: Geek-3340
slide: false
---
## はじめに
この記事は、エンジニア転職を目指す私がポートフォリオアプリの開発を通して学んだ、機能の実装方法を記録するシリーズものの備忘録です！

### アプリ概要

#### アプリ名：
Fameal（ファミール）～親子献立カレンダーアプリ～

#### 機能一覧：
- 料理登録・編集機能
- 離乳食登録・編集機能
- 材料登録・削除機能（料理のみ）
- 献立登録・編集機能（料理⇔離乳食、月表示⇔週表示で表示切替可能）
- 買い物リスト機能

#### 使用技術
フロントエンド
- Laravel Blade
- Alpine.js
- Tailwind CSS

バックエンド
- PHP 8.2 / Laravel 12

データベース
- PostgreSQL 17

インフラ（開発）
- Docker / Laravel Sail

インフラ（本番）
- Fly.io

UIライブラリ
- FullCalendar v6（CDN）

ビルドツール
- Vite

### 記事の内容
前回はMVCの流れに沿って料理の登録・削除機能を実装しました。今回は **「1つのレイアウトで複数ページの描画を管理する」** 仕組みについて書いていきます！

具体的には以下の2つのアプローチを取り上げます。

1. **ルート名**に応じて `@if` でインクルードするBladeテンプレートを切り替える
2. **URLパラメータ**を使って、その引数の値によってBladeの描画を切り替える

## やりたいこと

アプリのコンテンツページが増えてくると、ページごとにレイアウトファイルを作っていては管理が大変になります。Famealでは「料理登録」「献立カレンダー」「買い物リスト」など複数の機能ページがありますが、**ヘッダーやサイドバーは共通**です。

そこで今回のような構成にしました。

```
layouts/app.blade.php（共通レイアウト）
└─ リクエストのURLに応じて...
     ├─ /dishes     → contents/dishes.blade.php をinclude
     ├─ /schedules  → contents/schedules.blade.php をinclude
     └─ /shopping   → contents/shopping.blade.php をinclude
```

「どのURLへのリクエストか」をBladeの中で判定することで、1つのレイアウトから複数のコンテンツを出し分けることができます。

## ルートに名前をつける

Bladeの中でルートを判定するためには、まずルートに名前をつけておく必要があります。`->name()` を使うと、そのルートに識別名を付与できます。

```php:routes/web.php
Route::get('/dishes', [DishesController::class, 'index'])->name('dishes.index');
Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules.index');
Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping.index');
```

命名の慣習は `リソース名.アクション名` の形式です。

| ルート名 | 意味 |
|---|---|
| `dishes.index` | 料理の一覧ページ |
| `schedules.index` | 献立カレンダーのページ |
| `shopping.index` | 買い物リストのページ |

名前をつけると、Bladeから `route()` ヘルパーでURLを生成できるようになります。

```blade
<a href="{{ route('dishes.index') }}">料理登録</a>
```

URLを直書きしないので、後でルートのパスを変更してもリンクが壊れません。

## ルート名でテンプレートを切り替える

### request()->routeIs() とは？

`request()->routeIs('ルート名')` は、現在のリクエストが指定したルート名に一致するかを `true / false` で返すメソッドです。Bladeの `@if` と組み合わせることで、表示内容をルートごとに切り替えられます。

### レイアウトでヘッダーを切り替える

共通レイアウトの中で、コンテンツページかどうかによってヘッダーを出し分けます。

```blade:resources/views/layouts/app.blade.php
@if (request()->routeIs('dishes.index') ||
        request()->routeIs('schedules.index') ||
        request()->routeIs('shopping.index'))
    @include('layouts.partials.app-header')
@else
    @include('layouts.partials.top-header')
@endif

{{ $slot }}
```

`||`（OR条件）でルート名を並べることで、複数のページに同じヘッダーを使い回せます。

### コンテンツページで表示内容を切り替える

次に、コンテンツの中身を切り替えるBladeファイルを作ります。`@if / @elseif / @else` のチェーンで、ルート名に応じて `@include` するファイルを変えます。

```blade:resources/views/contents.blade.php
@if (request()->routeIs('dishes.index'))
    @include('contents.dishes')
@elseif (request()->routeIs('schedules.index'))
    @include('contents.schedules')
@elseif (request()->routeIs('shopping.index'))
    @include('contents.shopping')
@endif
```

各コントローラーから `view('contents', ...)` を返すようにすれば、URLが変わるたびにここで描画テンプレートが自動的に切り替わります。

### ワイルドカードも使える

`routeIs()` はワイルドカード `*` に対応しているので、プレフィックスが共通なルートをまとめて判定することもできます。

```blade
{{-- 'admin.' で始まるすべてのルートに一致 --}}
@if (request()->routeIs('admin.*'))
    @include('layouts.partials.admin-header')
@endif
```

## URLパラメータで描画を切り替える

ルート名による切り替えは「ページ単位」の制御に向いていますが、**同じページ内でも表示モードを切り替えたい**場面があります。Famealの献立カレンダーでは「月表示」と「週表示」を同じルートで扱っています。

このような場合は、URLにパラメータを持たせてBladeに渡す方法が便利です。

### ルートにパラメータを追加する

`{パラメータ名}` の形式でURLにパラメータのプレースホルダーを追加します。

```php:routes/web.php
Route::get('/schedules/{viewType}', [SchedulesController::class, 'index'])
    ->where(['viewType' => 'month|week'])
    ->name('schedules.index');
```

`->where()` に正規表現を指定することで、許可する値を制限できます。ここでは `month` か `week` 以外のURLは404になります。これによりBladeでの条件分岐が安全になります。

### コントローラーでパラメータを受け取る

コントローラーのメソッドの引数にパラメータ名と同名の変数を用意すると、Laravelが自動的に値を渡してくれます。

```php:app/Http/Controllers/SchedulesController.php
public function index($viewType)
{
    return view('contents.schedules', compact('viewType'));
}
```

`compact('viewType')` でBladeに変数を渡しています。

### Bladeでパラメータ値を使って分岐する

Bladeに渡った `$viewType` の値を `@if` で判定して、表示を切り替えます。

```blade:resources/views/contents/schedules.blade.php
@if ($viewType === 'month')
    @include('contents.schedules.month')
@else
    @include('contents.schedules.week')
@endif
```

また、Bladeの三項演算子を使って、JavaScriptライブラリへ渡す設定値を切り替えることもできます。

```blade:resources/views/contents/schedules.blade.php
<div data-initial-view="{{ $viewType === 'week' ? 'dayGridWeek' : 'dayGridMonth' }}">
</div>
```

### リンクでパラメータを渡す

パラメータ付きルートへのリンクは、`route()` ヘルパーの第2引数に配列で渡します。

```blade
<a href="{{ route('schedules.index', ['viewType' => 'month']) }}">月表示</a>
<a href="{{ route('schedules.index', ['viewType' => 'week']) }}">週表示</a>
```

## まとめ

今回はBladeでリクエストに応じた描画制御を実装しました。

- **`->name()`** でルートに名前をつけると、Bladeや `route()` ヘルパーから参照しやすくなる
- **`request()->routeIs()`** を `@if` と組み合わせると、現在のルートに応じて `@include` するテンプレートを切り替えられる
- **`{パラメータ}`** をルートに持たせることで、同じルートでもURLの値によって描画を変えられる
- **`->where()`** でパラメータの値を制限しておくと、想定外のリクエストを弾けて安全

# view の Tips

## リクエストに応じて描画するコンテンツを変える方法

例えば meta 情報などを使いまわすための blade layout を作成中に、トップページとコンテンツページのどちらで使用するかによって header を変えたいなどといった場合があると思います。(以下参照)

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- 省略 -->
    </head>

    <body class="font-sans text-text">
        <!-- headerをリクエストによって変えたい -->
        <main>{{ $slot }}</main>
    </body>
</html>
```

これを実装するにはいくつかやり方がありますが、今回は２つほど紹介します。
<br>

### 1. @auth/@guest を用いた方法

この方法は Laravel+Breeze において、ログイン済みか否かでしか制御できませんが、とても簡潔に書くことが出来ます。

```html
@auth
<p>ログインユーザーの表示内容</p>
@endauth

@guest
<p>ゲストユーザーの表示内容</p>
@endguest
```

> この＠～は blade のディレクティブといい html 形式の blade を書く上で、便利な機能群だと思ってもらえたらいいです。

### 2. @if()を用いた方法

この方法はリクエストによって柔軟に対応可能で上記の方法では実装が難しい場合は、こちらを使用するといいと思います。
書き方としては if 文と同様で以下のように書きます。

```html
@if (request()->routeIs('top.page'))
<main>ルートtop.pageがリクエストされた場合のコンテンツ</main>
@else
<main>ルートtop.page以外がリクエストされた場合のコンテンツ</main>
@endif
```

<br>
以上を踏まえてトップページとコンテンツページのどちらで使用するかによって header を切り替えるテンプレートを作成すると以下のように書けます。

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- 省略 -->
    </head>
    <body>
        @if (request()->routeIs('top.page'))
            @include('top-header')
            <main>
                {{ $slot }}
            </main>
        @else
            @include('app-header')
            <main>
                @auth
                    <p>{{$user->name}}様</p>
                @endauth
                @guest
                    <p>ゲスト様</p>
                @endguest
                <div class="w-3/4 h-auto border">
                    {{ $slot }}
                </div>
            </main>
        @endif
    </body>
</html>
```
上記では以下のような処理を実装しています。
- ページへのリクエストがtop.pageルートか否かによって、@includeで読み込むheaderのテンプレートを切り替える
    > @includeは別のbladeテンプレートを読み込むためのディレクティブです。

- リクエストがtop.pageルートではない場合、ログイン中か否かによってコンテンツを切り替える
    > 尚、`{{$user->name}}`でUserモデルを介してログイン中のユーザー名を取得しています。

このようにLaravelではディレクティブを応用することにより、より再利用性の高いテンプレートを作成し、効率的なフロントエンド開発を行うことが出来ます。

## langフォルダによるアプリ表示言語の制御
Laravelプロジェクトにおいてbladeで描画するテキストはlang>ja>ja.jsonを活用して英語・日本語などを効率的に切り替えることが出来ます。

### langフォルダとは？
Laravelプロジェクトにおけるlangフォルダを指します。
このファイルはデフォルトではプロジェクトにありませんので、以下のコマンドで作成する必要があります。
```bash
./vendor/bin/sail artisan lang:publish
```
これによりプロジェクトのルートディレクトリにlangフォルダが作成されます。

ただし、この時点では日本語用のファイルは無いため次のコマンドで作成します。
```bash
./vendor/bin/sail composer require askdkc/breezejp --dev
./vendor/bin/sail artisan breezejp
```
これにより`/lang/ja.json`が作成されていると思います。
このファイルを編集して翻訳テキストの編集や参照を行っていきます。
<br>

### 言語ファイルの参照・編集
`ja.json`を開くと以下のようになっています。
```json
{
    "Name": "アカウント名",
    "Profile": "アカウント",
    "Profile Information": "アカウント情報",
    "Profile Menu": "アカウント設定",
    "Cancel": "キャンセル",
    // 省略
}
```
このように`"英語":"日本語",`のような記法で翻訳テキストが定義されており、この内容は自由に追加や編集することが出来ます。

また参照する際は、bladeより以下のように参照します。
```html
<!-- blade -->
<h1>{{ __('Profile') }}</h1>
<p>{{ __('Profile Information') }}</p>
<p>{{ __('Name') }}</p>
```
このように`{{__('ここに翻訳テキストの英語')}}`を記述することにより、日本語設定中には定義した日本語（`Profile`であれば`アカウント`）が描画されます。

ではこの言語設定の切り替えはどうやって行うのか？
<br>

### 表示言語の切り替え
`/config/app.php`を開き、以下の部分を編集
```php
'locale' => env('APP_LOCALE', 'ja'), // ここをja/enで切り替え

'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

'faker_locale' => env('APP_FAKER_LOCALE', 'ja_JP'), //ここをja_JP/en_USで切り替え

// 参照してるenvファイルの内容も同様に切り替える
```

## カスタムデータを用いたJSとの連携(HTMLの機能)
### カスタムデータとは？
JSからbladeのDOMを取得する際に、一緒にデータを受け取るための機能

### 構文
```html
<!-- HTML（ blade ） -->
<div id="js" data-custom-data="Hello!"></div>
```
```js
// JS
const $dom = document.getElementById('js');

console.log($dom.dataset.customData); //出力：Hello!
```
HTML側では`data-データ名="値"`でJSに渡すデータを指定しJS側では`DOM.dataset.データ名`で取得できます。

この`DOM`はデータを指定した要素である必要があります。

`データ名`はHTMLで書いたデータ名から`-`を省きキャメルケースで書きます。

### 応用
- **route（URL）を渡す場合**
    ```html
    <!-- HTML（ blade ） -->
    <div id="js" data-custom-data="{{route(`post.index`)}}"></div>
    ```
    ```js
    // JS
    const $dom = document.getElementById('js');

    console.log($dom.dataset.customData); //出力例：https://app.post.index
    ```
    上記のように`{{route('ルート名')}}`と書くことで、URLに変換されJSに渡されます。

<br>

- **コントローラーから受け取ったデータを渡す場合**
    コントローラーからビュー、ビューからJSへデータを渡す処理を行いたい場合は

    以下のようになります。
    ```php
    // コントローラー
    $name = '名前'
    $array = [
        title => '題名',
        description => '説明',
    ];
    return view('index', compact('name','array'))
    ```
    ```html
    <!-- index.blade.php -->
    <div id="js"
        data-custom-data-name="$name"
        data-custom-data-array='@json($array)'></div>
    ```
    ```js
    // JS
    const $dom = document.getElementById('js');

    console.log($dom.dataset.customDataName); //出力例：名前
    console.log(Json.parse($dom.dataset.customDataArray[title])); //出力例：題名
    ```
    上記のように文字列や数値等のデータは変数でそのまま渡せますが

    配列やオブジェクトをJSに渡す時は`@json`を用いて渡し、JS側で

    `Json.parse()`を用いて受け取ることで配列やオブジェクトとして

    扱うことが出来ます。

## bladeコンポーネントについて

## `$attributes` を用いたコンポーネント属性との merge

### 基本的な考え方
- Blade コンポーネントに渡される **HTML 属性（class, id, style など）** をまとめて受け取るのが `$attributes`。
- `$attributes->merge([...])` を使うことで「デフォルトの属性」と「呼び出し側で渡した属性」をマージできる。

### 使用例

#### コンポーネント定義 (`resources/views/components/button.blade.php`)
```html
<button {{ $attributes->merge(['class' => 'px-4 py-2 rounded bg-blue-500 text-white']) }}>
    {{ $slot }}
</button>
```

#### 呼び出し側
```html
<x-button class="bg-red-500">削除</x-button>
```

#### 実際の出力
```html
<button class="px-4 py-2 rounded bg-blue-500 text-white bg-red-500">
    削除
</button>
```

### ポイント
- 呼び出し側のクラスが後ろに追加される。
- 必要に応じて **`$attributes->class([...])`** を使うと、条件付きクラスをより便利に扱える。


## `$props` での引数受け取り

### 基本的な考え方
- コンポーネントに渡す **明示的な引数**（title, type など）を受け取る仕組み。
- コンポーネントの先頭で `@props([...])` を使って宣言する。

### 使用例

#### コンポーネント定義 (`resources/views/components/alert.blade.php`)
```html
@props(['type' => 'info', 'message'])

<div {{ $attributes->merge(['class' => 'p-4 rounded']) }}>
    <strong>{{ ucfirst($type) }}:</strong> {{ $message }}
</div>
```

#### 呼び出し側
```html
<x-alert type="error" message="エラーが発生しました" class="bg-red-100 text-red-700" />
```

#### 実際の出力
```html
<div class="p-4 rounded bg-red-100 text-red-700">
    <strong>Error:</strong> エラーが発生しました
</div>
```

### ポイント
- `@props(['name' => 'default'])` でデフォルト値を設定可能。
- `$attributes` と組み合わせることで「見た目」と「動的データ」をきれいに分離できる。


## `match()` での分岐処理

### 基本的な考え方
- PHP 8 から使える式ベースの分岐処理。
- Blade 内でも利用可能で、コンポーネントのスタイル切り替えに便利。

### 使用例

#### コンポーネント定義 (`resources/views/components/badge.blade.php`)
```php
@props(['status' => 'default'])

@php
    $classes = match($status) {
        'success' => 'bg-green-100 text-green-800',
        'error'   => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        default   => 'bg-gray-100 text-gray-800',
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 rounded text-sm $classes"]) }}>
    {{ $slot }}
</span>
```

#### 呼び出し側
```html
<x-badge status="success">完了</x-badge>
<x-badge status="error">失敗</x-badge>
<x-badge>未定義</x-badge>
```

#### 実際の出力
```html
<span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">完了</span>
<span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">失敗</span>
<span class="px-2 py-1 rounded text-sm bg-gray-100 text-gray-800">未定義</span>
```

### ポイント
- `if` や `switch` よりシンプルに書ける。
- 必ず何かを返すため、変数代入に向いている。

---

## まとめ
- `$attributes` → HTML属性をまとめて受け取り、merge でマージ可能。  
- `$props` → 明示的に渡した引数を受け取る仕組み。  
- `match()` → スタイルや状態ごとの分岐に便利。  

これらを組み合わせることで、 **再利用性が高く、柔軟なコンポーネント** を作れる。

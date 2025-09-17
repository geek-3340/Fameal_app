# blade の Tips

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
@endauth @guest
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

## 翻訳ファイルの参照・編集方法


## カスタムデータを用いたJSとの連携


## $attributesを用いたコンポーネント属性とのmerge


## $propsでの引数受け取り、match()での分岐処理
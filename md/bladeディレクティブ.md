# Laravel Blade ディレクティブまとめ

LaravelのBladeテンプレートエンジンには、コントローラやモデルから受け取ったデータを便利に表示・制御するためのディレクティブがあります。  
ここでは **よく使うディレクティブ** を使用例と一緒に解説します。

---

## 1. `@if / @elseif / @else / @endif`
条件分岐を行うときに使用します。

```php
@if ($user->isAdmin())
    <p>管理者です。</p>
@elseif ($user->isEditor())
    <p>編集者です。</p>
@else
    <p>一般ユーザーです。</p>
@endif
```

---

## 2. `@unless`
条件が **false** の場合に処理を実行します。（`if (!条件)` と同じ）

```php
@unless ($user->isAdmin())
    <p>あなたは管理者ではありません。</p>
@endunless
```

---

## 3. `@isset / @endisset`
変数がセットされているかどうかを判定します。

```php
@isset($title)
    <h1>{{ $title }}</h1>
@endisset
```

---

## 4. `@empty / @endempty`
変数が空かどうかを判定します。（`empty()` のBlade版）

```php
@empty($records)
    <p>データがありません。</p>
@endempty
```

---

## 5. `@auth / @endauth`
ユーザーがログインしている場合のみ表示します。

```php
@auth
    <p>{{ Auth::user()->name }} さん、ようこそ！</p>
@endauth
```

---

## 6. `@guest / @endguest`
未ログイン（ゲストユーザー）の場合に表示します。

```php
@guest
    <a href="{{ route('login') }}">ログイン</a>
@endguest
```

---

## 7. `@foreach / @endforeach`
配列やコレクションをループ処理します。

```php
@foreach ($users as $user)
    <li>{{ $user->name }}</li>
@endforeach
```

---

## 8. `@for / @endfor`
数値ベースでループします。

```php
@for ($i = 0; $i < 5; $i++)
    <p>カウント: {{ $i }}</p>
@endfor
```

---

## 9. `@while / @endwhile`
条件付きのループ処理を行います。

```php
@php $count = 0; @endphp

@while ($count < 3)
    <p>{{ $count }}</p>
    @php $count++; @endphp
@endwhile
```

---

## 10. `@include`
部分テンプレートを読み込みます。

```php
@include('partials.header')
```

引数を渡すことも可能です。

```php
@include('partials.card', ['title' => '記事タイトル'])
```

---

## 11. `@extends` と `@section / @endsection`
レイアウト継承を行います。

`layouts/app.blade.php`
```php
<html>
    <body>
        <header>ヘッダー</header>
        <main>
            @yield('content')
        </main>
    </body>
</html>
```

`home.blade.php`
```php
@extends('layouts.app')

@section('content')
    <h1>トップページ</h1>
@endsection
```

---

## 12. `@csrf`
フォームにCSRFトークンを埋め込みます。（セキュリティ必須）

```php
<form method="POST" action="/post">
    @csrf
    <input type="text" name="title">
    <button type="submit">送信</button>
</form>
```

---

## 13. `@method`
フォームで `PUT` や `DELETE` を送信する場合に使用します。

```php
<form method="POST" action="/post/1">
    @csrf
    @method('PUT')
    <input type="text" name="title">
    <button type="submit">更新</button>
</form>
```

---

## 14. `@switch / @case / @break / @default / @endswitch`
`switch` 文をBladeで書くときに使います。

```php
@switch($role)
    @case('admin')
        <p>管理者</p>
        @break

    @case('editor')
        <p>編集者</p>
        @break

    @default
        <p>一般ユーザー</p>
@endswitch
```

---

## 15. `@php`
Blade内で生のPHPコードを記述します。（必要最低限にとどめるのがおすすめ）

```php
@php
    $now = date('Y-m-d H:i:s');
@endphp

<p>現在時刻: {{ $now }}</p>
```

---

# まとめ
- 条件分岐系 → `@if`, `@unless`, `@isset`, `@empty`
- ユーザー判定系 → `@auth`, `@guest`
- ループ系 → `@foreach`, `@for`, `@while`
- レイアウト系 → `@extends`, `@section`, `@include`
- フォーム系 → `@csrf`, `@method`

Bladeのディレクティブをうまく使うことで、ビューが見やすく、メンテナンス性の高いコードを書けます。

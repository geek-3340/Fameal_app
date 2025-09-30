# Alpine.js 機能解説資料

## 1. `x-data`（状態管理）

``` html
<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }">
```

-   Alpine.js の **状態（変数）を定義するオブジェクト**。
-   この例では：
    -   `open` → モーダルの開閉状態
    -   `selectedDate` → 選択された日付
    -   `formattedDate` → 表示用に整形した日付
    -   `dishes` → 選択された日付の料理一覧（配列）

------------------------------------------------------------------------

## 2. イベントリスナー

### `@open-modal.window`

``` html
@open-modal.window="
  open = true;
  selectedDate = $event.detail.date;
  formattedDate = $event.detail.formattedDate;
  dishes = (window.dishesByDate && window.dishesByDate[selectedDate]) ? window.dishesByDate[selectedDate] : [];
"
```

-   **カスタムイベント `open-modal` を window で受け取る**。
-   `$event.detail` に渡されたデータ（日付・整形日付など）を Alpine
    の変数に格納。

------------------------------------------------------------------------

### `@click`

``` html
<button @click="open = false">閉じる</button>
<button @click="openLeft = !openLeft">左メニュー切替</button>
<button @click="openRight = true">右メニュー開く</button>
```

-   クリックイベントで変数を更新。
-   モーダルやメニューの開閉トグルに利用。

------------------------------------------------------------------------

### `@click.away`

``` html
<div x-show="openLeft" @click.away="openLeft = false">
```

-   コンポーネント外をクリックしたときに閉じる。

------------------------------------------------------------------------

### `@submit`

``` html
<form :action="`/menus-dishes/${dish.id}`" method="post" @submit>
```

-   フォーム送信イベントを補足可能。
-   ここでは処理は未指定 → そのままサーバーに送信。

------------------------------------------------------------------------

## 3. 表示制御

### `x-show`

``` html
<div x-show="open">
```

-   条件が true のとき表示。false のとき `display: none;`。

### `x-cloak`

``` html
<div x-show="open" x-cloak>
```

-   Alpine.js が起動する前に要素を一瞬でも見せないように非表示。

### `x-if`

``` html
<template x-if="dishes.length > 0">
```

-   条件を満たすときに **DOM を生成**。

### `x-for`

``` html
<template x-for="dish in dishes" :key="dish.id">
  <li><span x-text="dish.dish_name"></span></li>
</template>
```

-   配列をループして要素を生成。
-   `:key` で一意性を確保。

------------------------------------------------------------------------

## 4. データバインディング

### `x-text`

``` html
<span x-text="formattedDate"></span>
```

-   変数の値を要素のテキストに反映。

### `:value`

``` html
<input type="hidden" name="date" :value="selectedDate">
```

-   input の value を変数にバインド。

### `:class`

``` html
:class="openLeft ? 'rotate-45' : 'rotate-0'"
```

-   条件に応じてクラスを切り替え。
-   ハンバーガーメニューのアニメーションに利用。

### `:action`

``` html
<form :action="`/menus-dishes/${dish.id}`">
```

-   URL を動的に生成（テンプレートリテラル使用）。

------------------------------------------------------------------------

## まとめ

このコードで使われている Alpine.js の機能は：

-   **状態管理** → `x-data`
-   **イベント処理** → `@click`, `@open-modal.window`, `@click.away`
-   **表示制御** → `x-show`, `x-if`, `x-for`, `x-cloak`
-   **データバインディング** → `x-text`, `:value`, `:class`, `:action`

➡ Vue.js ライクな書き方で、軽量かつシンプルに
**リアクティブUI（モーダルやメニュー開閉）** を実装している。

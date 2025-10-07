# Blade × FullCalendar × Alpine.js モーダル実装完全解説

## 🎨 概要

このドキュメントでは、Blade（Laravel）とFullCalendar、Alpine.jsを組み合わせてモーダルウィンドウを実装する仕組みを、初学者向けに丁寧に解説します。\
あわせて、「ページリロード時にモーダルが一瞬表示されてしまう」問題の原因と対処法（`x-cloak`）も扱います。

------------------------------------------------------------------------

## 🧩 モーダルが開く処理の流れ

### 1. Bladeでの構成

Bladeでカレンダー領域とモーダルを定義します。

``` blade
<div id="calendar"
    data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
    data-month-url="{{ route('menus.month.index') }}"
    data-week-url="{{ route('menus.week.index') }}"
    data-menus-event='@json($events)'
    data-menus-by-date='@json($menusByDate)'>
</div>

<x-day-modal :dishes="$dishes" />
```

`<div id="calendar">`にカレンダー表示やイベント情報を渡し、
`<x-day-modal>`でモーダルコンポーネントを読み込みます。

------------------------------------------------------------------------

### 2. FullCalendar 側の処理

FullCalendarで各日セルにクリック用リンク（鉛筆アイコン）を追加します。

``` js
dayCellContent(arg) {
  return { html: arg.date.getDate() + `${modalLinkSvg()}` };
}
```

各日セルのDOM生成後に、リンククリック時のイベントリスナを登録します。

``` js
link.addEventListener("click", (e) => {
  e.preventDefault();
  const jstDate = jst(arg.date);
  const formattedDate = dateFormat(arg.date);
  window.dispatchEvent(
    new CustomEvent("open-modal", {
      detail: { date: jstDate, formattedDate },
    })
  );
});
```

🔹 `window.dispatchEvent()` ... イベントを発火（通知）するメソッド。\
🔹 `CustomEvent()` ...
独自イベントを作るためのオブジェクト。`detail`で追加情報を渡せる。

この時点で、「`open-modal`というイベントがwindow上で発生した」という状態になります。

------------------------------------------------------------------------

### 3. Alpine.js 側でイベントを受け取る

Bladeの`x-day-modal`コンポーネント内で、Alpine.jsを使ってモーダルを制御します。

``` blade
<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }"
    @open-modal.window="
        open = true;
        selectedDate = $event.detail.date;
        formattedDate = $event.detail.formattedDate;
        dishes = (window.dishesByDate[selectedDate]) ? window.dishesByDate[selectedDate] : [];
    ">
  <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
    <div @click.away="open = false" class="bg-white p-6 rounded shadow w-96">
      <!-- モーダル内容 -->
    </div>
  </div>
</div>
```

🔹 `@open-modal.window` ...
window上で発生した`open-modal`イベントを監視して処理を実行。\
🔹 `$event.detail` ... `CustomEvent`で渡されたデータを受け取る。\
🔹 `x-show="open"` ... openがtrueのときモーダルを表示。\
🔹 `x-cloak` ... 初期表示でのチラつきを防ぐ（後述）。

------------------------------------------------------------------------

### 4. 全体の流れ図

    FullCalendar(JS)
       ↓ クリック
    window.dispatchEvent(new CustomEvent('open-modal', { detail: {...} }))
       ↓
    Alpine.js（Blade）
    @open-modal.window="..." を受け取り
    open = true → モーダル表示

------------------------------------------------------------------------

## ⚡️ ページリロード時にモーダルが一瞬表示される原因

### 🧠 原因

Alpine.jsはJavaScriptで動作するため、初期化される前は`x-show="open"`がまだ効いていません。\
そのため、**ブラウザが最初にHTMLを描画する瞬間にモーダルが見えてしまう**現象（FOUC：Flash
of Unstyled Content）が起こります。

### ✅ 解決策：`x-cloak`を使う

Alpine.jsでは、`x-cloak`を使って「Alpineが初期化するまで要素を強制的に非表示」にできます。

``` blade
<div x-show="open" x-cloak class="fixed inset-0 bg-main bg-opacity-50 z-50">
  <!-- モーダル内容 -->
</div>
```

CSSで以下を定義します：

``` css
[x-cloak] { display: none !important; }
```

Tailwindを使っている場合：

``` css
@layer utilities {
  [x-cloak] { display: none !important; }
}
```

これでAlpineの初期化前でも要素は非表示になり、ページリロード時のチラつきがなくなります。

------------------------------------------------------------------------

## ✨ まとめ

  機能                       役割
  -------------------------- ------------------------------------------------
  `window.dispatchEvent()`   イベントをwindow上に発火する
  `CustomEvent()`            独自イベントを作り、detailでデータを渡す
  `@open-modal.window`       window上のイベントをAlpine側で受け取る
  `x-cloak`                  初期レンダリング時に一瞬要素が見える問題を防ぐ

------------------------------------------------------------------------

## 💡 改善ポイント（おすすめ）

-   `@click.away="open = false"` → モーダル外クリックで閉じる\
-   `@keydown.escape.window="open = false"` → Escキーで閉じる\
-   `<template x-if="open">...</template>` →
    open=trueのときだけDOMを生成

------------------------------------------------------------------------

## 🧾 まとめ（要点）

-   FullCalendar → `window.dispatchEvent()` で独自イベントを送信。\
-   Alpine.js → `@open-modal.window` で受信し、`open = true`
    でモーダル表示。\
-   ページリロードで一瞬モーダルが出るのは、Alpine初期化前のFOUC。\
-   `x-cloak`で解決できる。

------------------------------------------------------------------------

これで「FullCalendarとAlpineを組み合わせたモーダル処理の全体像」と「リロード時チラつき防止の仕組み」が完全に理解できます✨

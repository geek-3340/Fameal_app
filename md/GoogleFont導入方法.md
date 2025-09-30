# bladeでGoogle Fontsを使用する方法
## ① headでGoogleFontsを取得
bladeファイルの`head`内でGoogleFontsを使用するための以下のコードを記述する
```html
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap"
    rel="stylesheet"
/>
```
上記の`Noto+Sans+JP`の部分に使用したいFontFamilyを記述し、`:wght@100..900`の部分で取得するFontSizeを指定する。

### FontSize例
- `Noto+Sans+JP:wght@100..900&display=swap`
    
    NotoSansJPの全てのサイズを取得

- `Noto+Sans+JP:wght@700&display=swap`
    
    NotoSansJPのBoldサイズ（700）を取得

- `Noto+Sans+JP&display=swap`
    
    NotoSansJPのRegularサイズ（400）を取得
    
※Regularに関しては構文を省略
    
※fontによってサポートしているサイズが異なるので、公式からのmetaコードをコピペを推奨

## ② tailwindCSSでcustom stylesを作成
`tailwind.config.js`を開き、以下のコードを記述する
```javascript
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // ここにカスタムスタイルを定義する
                google: ['Sriracha', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
```
- `fontFamily:{}`内にスタイルのエイリアス（この場合font-family）を設定する
- `base:`はエイリアス名でbladeから呼び出す時は、この名前を使用する
- `'Sriracha'`はGoogleFontsの提供するフォントであり、ここにfont名を記述することで使用できる
- `...defaultTheme.fontFamily.sans`はTailwind CSS のデフォルトのsans-serifフォントファミリーの配列を展開しており、GoogleFontsが利用できなかった場合の候補として設定している

## ③ bladeでGoogleFontsを使用
`head`で取得し、`tailwind.config.js`で作成したカスタムスタイルを使用します。
以下のようにclass属性内で`font-エイリアス名`とすることにより、使用できます。
```html
<!-- 省略 -->
<body class="font-google antialiased">
        <div class="min-h-screen bg-gray-100">
<!-- 省略 -->
```

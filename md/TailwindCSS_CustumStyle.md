# TailwindCSS Custom styles設定方法
TailwindCSSでオリジナルのスタイル（custom styles）を作成する方法

まず`tailwind.config.js`を開きます。
```js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
                // ここにカスタムスタイルを定義する
            },
        },
    plugins: [forms],
};
```
extendオブジェクトが定義されているので、この中にカスタムスタイルを定義します。

```js
// 例
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            // ここにカスタムスタイルを定義する
            fontFamily: {
                sans: ["Noto Sans JP", ...defaultTheme.fontFamily.sans],
                monoton: ["Monoton", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: "#f89900",
                bg: "#ffffff",
                filter: "#ffc870",
                text: "#3d3d3d",
                subtext: "#ffffff",
                graytext: "#9f9f9f",
                link: "#0022ff",
            },
            boxShadow: {
                custom: "0 0 8px 3px rgba(0,0,0,0.15)",
            },
        },
    },

    plugins: [forms],
};
```
上記の場合
- fontFamily
- colors
- boxShadow

の３つのカスタムスタイルを作成しています。

### fontFamily
`sans`や`monoton`が呼び出しに使用するエイリアスで、`[]`の中に呼び出すスタイルを定義します。

例えば`Noto Sans JP`のように直接font familyを定義することもできれば、`...defaultTheme.fontFamily.sans`のようにTailwindCSSの機能で滑り止めスタイルをまとめて呼び出し定義することもできます。

### colors
デザインカンプやプロトタイプ等の画面設計書で、使用する色が決まっている場合などに、この`colors`カスタムスタイルが大活躍します。

複数の色を指定してエイリアスで名前（キー）をつけることにより、色の用途が可視化され、直感的にスタイルを当てられます。



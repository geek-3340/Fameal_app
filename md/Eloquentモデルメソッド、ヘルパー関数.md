# Eloquentモデルメソッド、ヘルパー関数

## 目次
- [user()](#user)
- [validate()](#validate)
- [with()](#with)
- [where()](#where)
- [whereHas()](#wherehas)
- [find()](#find)
- [auth()](#auth)
- [id()](#id)
- [create()](#create)
- [firstOrCreate()](#firstorcreate)
- [delete()](#delete)
- [get()](#get)
- [all()](#all)
- [save()](#save)
- [session()](#session)
- [view()](#view)
- [compact()](#compact)
- [back()](#back)
- [redirect()](#redirect)
- [intended()](#intended)
- [authorize()](#authorize)
- [flash()](#flash)
- [update()](#update)
- [filled()](#filled)
- [query()](#query)
- [latest()](#latest)
- [paginate()](#paginate)

---

- ### user()
    ユーザー情報を取得

    **使用例**
    ```php
    $user = Auth::user();
    // ログイン中ユーザー情報を取得し変数格納
    ```

---

- ### validate()
    リクエストのバリデーションチェック

    **使用例**
    ```php
    $request->validate([
        'name' => 'required',
    ]);
    // validate(['input name属性の値' => '条件'])

    // 主なルール
    // required	必須入力
    // email	メールアドレス形式であること
    // integer	数値であること
    // min:0	最小値 0 以上
    // nullable	空でもOK
    ```

---

- ### with()
    リレーションモデルを事前にまとめて取得する
    `N＋１問題対策のために必須`

    **使用例**
    ```php
    // DishテーブルとリレーションしたUserテーブルをまとめて取得
    $dishes = Dish::with('user')->get();
    ```

    **N＋１問題とは？**

    最初にデータを取った後、ループ処理の中でそれぞれに関連するデータを取るために追加でN回クエリが走りパフォーマンス悪化につながる現象
    ```php
    // with()を使用しない場合
    $dishes = Dish::all(); // Dishテーブルの全カラム取得（SQL１回）
    $dishUsers = [];
    foreach ($dishes as $dish) {
        // userのデータは未取得であるため、ループ回数分SQLが走る
        $dishUser[] = $dish->user->id(); 
    }

    // with()を使用
    // userテーブルもまとめて事前に取得（SQL１回）
    $dishes = Dish::with('user')->get();
    $dishUsers = [];
    foreach ($dishes as $dish) {
        // userのデータは取得済みであるため、SQLは発行されない！
        $dishUser[] = $dish->user->id(); 
    }
    ```
    
---

- ### where()
    DBからレコードを検索するときに条件を指定する関数

    **使用例**
    ```php
    // dishesテーブルからuser_id が 1 のレコードだけ取ってくる
    $dishes = Dishes::where('user_id', 1)->get();

    // dishesテーブルからprice が 500 以上のレコードだけ取ってくる
    Dishes::where('price', '>=', 500)->get();

    // 複数条件：->でメソッドチェーンすることにより可能
    Dishes::where('user_id', 1)->where('is_public', true)->get();
    // 一つにまとめることも可能
    Dishes::where([
        ['user_id', 1],
        ['is_public', true],
    ])->get();

    // OR条件
    Dishes::where('name', 'カレー')
      ->orWhere('name', 'ラーメン')
      ->get();
    ```

---

- ### whereHas()
    DBからレコードを検索するときに、**リレーションテーブルに**条件を指定する関数

    **使用例**
    ```php
    // Userテーブルのカラムを取得する上で、リレーション先であるdishesテーブルに対して条件を指定する
    $users = User::whereHas('dishes', function ($query) {
        $query->where('is_public', true);
    })->get();

    /* 
    以下のような構文で書く
    whereHas('リレーション先', function ($query) {
        $query->where('カラム名', 値);
    })->get();
    */

    ```

---

- ### find()
    主キーでレコード１件だけを探す
    
    **使用例**
    ```php
    //  dishesテーブルからid=5 のカラム1件を取得
    $dish = Dishes::find(5);
    $dish -> delete(); // そのカラムを削除

    // 強制的に「なければ404エラー」にしたいなら findOrFail() 
    $dish = Dishes::findOrFail(5);
    ```

---

- ### auth()
    ログインしているユーザーや認証情報を取得する

    **使用例**
    ```php
    $user = auth()->user();
    // 現在ログインしているユーザー情報を取得

    $id = auth()->id();
    // 現在ログインしているユーザーのIDだけ取得
    ```

---

- ### id()
    ログインユーザーのIDを取得する  
    （`auth()->id()` が基本。`Auth::id()` でも可）

    **使用例**
    ```php
    $id = auth()->id();
    // 現在ログインしているユーザーのidを返す（未ログインならnull）
    ```

---

- ### create()
    DBに新しいレコードを作成する（Eloquentモデルメソッド）

    **save()との違い**
    - モデルの$fillable に指定されたカラムしか保存できない
    - レコードの新規作成のみで更新はできない

    **使用例**
    ```php
    // mass assignmentを利用してレコード作成
    $dish = Dishes::create([
        'name' => 'カレー',
        'user_id' => auth()->id(),
    ]);

    // validateしたデータでレコードを作成する場合
    $validated = $request->validate([
            'name' => 'required',
        ]);
        $validated['user_id'] = auth()->id();
        Dishes::create($validated); // 変数を参照することもできる
    ```

---

- ### firstOrCreate()
    条件に一致するレコードがあれば取得し、なければ新規作成する

    **使用例**
    ```php
    $dish = Dishes::firstOrCreate(
        ['name' => 'カレー', 'user_id' => auth()->id()],
        ['price' => 500]
    );
    // nameとuser_idが一致するものを探し、なければ新規作成
    // 中間テーブルを用いた実装等で、同じ内容のレコードを無駄に作成したくないときに使える
    ```

---

- ### delete()
    レコードを削除する（Eloquentインスタンスメソッド）

    **使用例**
    ```php
    $dish = Dishes::find(1);
    $dish->delete();
    // id=1のレコードを削除
    ```

---

- ### get()
    クエリビルダの結果を「コレクション」として取得する

    **使用例**
    ```php
    $dishes = Dishes::where('user_id', auth()->id())->get();
    // 条件に一致する全レコードを取得
    ```

---

- ### all()
    テーブル内の全レコードを取得する  
    （`Model::all()` は `SELECT *` と同等）

    **使用例**
    ```php
    $dishes = Dishes::all();
    // dishesテーブルの全データを取得
    ```

---

- ### save()
    Eloquentモデルを保存する  
    （新規ならINSERT、既存ならUPDATE）

    **create()との違い**
    - $fillableを無視できる
    - レコードの新規作成と更新も可能

    **使用例**
    ```php
    // 新規作成
    $dish = new Dishes();
    $dish->name = 'ラーメン';
    $dish->user_id = auth()->id();
    $dish->save(); // レコードを作成

    // 更新
    $dish = Dishes::find(2);
    $dish->name = 'ラーメン';
    $dish->user_id = auth()->id();
    $dish->save(); // id(2)のレコードを更新
    ```

---

- ### session()
    セッションデータを取得・保存する

    **使用例**
    ```php
    // セッションに保存
    session(['key' => 'value']);

    // セッションから取得
    $value = session('key');

    // セッションから削除
    session()->forget('key');
    ```

---

- ### view()
    Bladeテンプレートを返す（コントローラーでよく使う）

    **使用例**
    ```php
    return view('contents', ['dishes' => $dishes]);
    // resources/views/contents.blade.php を表示しつつ変数を渡す
    ```

---

- ### compact()
    コントローラーからビューに変数を渡すときに便利な関数。<br>
    変数名をキー、変数の中身を値として配列を作る。

    **使用例**
    ```php
    $dishes = Dishes::all();
    return view('contents', compact('dishes'));
    // これは内部的にこう書くのと同じ
    return view('contents', ['dishes' => $dishes]);

    // 要は変数名とキー名を同じにしたいときのショートカット
    ```

---

- ### back()
    直前のページ（リファラー）にリダイレクトする

    **使用例**
    ```php
    return back();
    // 単純に直前のページへ戻る

    return back()->with('message', '保存しました');
    // セッションにフラッシュメッセージを渡しながら戻る
    ```

    **使いどころ**
    - 入力フォームでバリデーションエラーが出たとき
    - フォーム送信後に「同じ画面」に戻すとき

---

- ### redirect()
    指定した URL またはルートにリダイレクトする

    **使用例**
    ```php
    return redirect('/home');
    // URL を直接指定してリダイレクト

    return redirect()->route('home');
    // 名前付きルートを指定してリダイレクト

    return redirect()->route('home')->with('message', '保存しました');
    // セッションフラッシュを渡すことも可能
    ```

    **使いどころ**
    - 保存・削除などの処理後に「特定のページ」に飛ばしたい場合
    - 例：新規投稿後に一覧画面へ戻す

---

- ### intended()
    ユーザーがアクセスしようとしていたページにリダイレクトする  
    （なければデフォルトで指定した URL にリダイレクト）

    **使用例**
    ```php
    return redirect()->intended('/home');
    // 本来アクセスしたかったページに飛ばす
    // もし記録されていない場合は '/home' に飛ばす
    ```

    **使いどころ**
    - ログイン認証後のリダイレクト処理
    - 「戻る先」が毎回異なる場合

---

- ### authorize()
    認可処理を行い、権限がなければ 403 エラーを返す

    **使用例**
    ```php
    $this->authorize('update', $post);
    // PostPolicy の update メソッドでチェック
    ```

    **使いどころ**
    - コントローラやルートでユーザーの権限をチェックしたいとき
    - Policy や Gate と組み合わせて利用する

---

- ### flash()
    セッションに一時的な値を保存する（リロードすると消える）

    **使用例**
    ```php
    session()->flash('message', '保存しました');
    return back();
    ```

    **使いどころ**
    - フォーム送信後に「成功しました」などの一時メッセージを表示するとき
    - 一度きりの通知に適している

---

- ### update()
    モデルの既存レコードを更新する

    **使用例**
    ```php
    $dish = Dish::find(1);
    $dish->update([
        'name' => 'ラーメン',
    ]);
    ```

    **使いどころ**
    - データを一括で更新したいとき
    - `$model->fill([...])->save();` の省略形

---

- ### filled()
    リクエストに値が入っているかどうかを判定する（空文字は false）

    **使用例**
    ```php
    if ($request->filled('name')) {
        // name に値が入力されている場合の処理
    }
    ```

    **使いどころ**
    - 入力フォームで任意項目が入力されているかどうかチェックしたいとき
    - `has()` との違い：空文字は `filled()` では false 扱い

---

- ### query()
    モデルや DB クエリビルダを取得する

    **使用例**
    ```php
    $dishes = Dish::query()
        ->where('user_id', 1)
        ->get();
    ```

    **使いどころ**
    - モデルに対して柔軟なクエリを組み立てたいとき
    - 直接クエリビルダを操作したいとき

---

- ### latest()
    指定したカラム（デフォルトは `created_at`）で降順ソートする

    **使用例**
    ```php
    $latestDish = Dish::latest()->first();
    // created_at が一番新しいレコードを取得

    $latestUpdated = Dish::latest('updated_at')->get();
    // updated_at の新しい順ですべて取得
    ```

    **使いどころ**
    - 新しい順に並べたいとき
    - `orderBy('created_at', 'desc')` の省略形

---

- ### paginate()
    ページネーション付きでデータを取得する

    **使用例**
    ```php
    $dishes = Dish::paginate(10);
    // 1ページあたり10件取得

    return view('dishes.index', compact('dishes'));
    ```

    **使いどころ**
    - 一覧画面をページ分割して表示したいとき
    - Blade で `{{ $dishes->links() }}` を使えば簡単にページリンクを生成できる

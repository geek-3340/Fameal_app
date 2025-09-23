## controllerで多用するヘルパー関数
- ### user()
    ユーザー情報を取得

    **使用例**
    ```php
    $user = Auth::user();
    // ログイン中ユーザー情報を取得し変数格納
    ```
- ### validate()
    バリデーションチェック

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
- ### with()
    
- ### where()
- ### whereHas()
- ### find()
- ### findOrFail()
- ### auth()
- ### id()
- ### create()
- ### firstOrCreate()
- ### delete()
- ### get()
- ### all()
- ### save()
- ### session()
- ### view()
- ### compact()
- ### back()
- ### redirect()
- ### intended()
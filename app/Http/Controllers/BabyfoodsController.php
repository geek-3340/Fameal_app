<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;

class BabyfoodsController extends Controller
{
    public function index()
    {
        $user=auth()->user();
        $userName=$user->name;
        $babyfoods = Dishes::where('user_id', auth()->id())->where('type', 'babyfood')->get();
        $energyFoods = $babyfoods->where('category', 'エネルギー');
        $proteinFoods = $babyfoods->where('category', 'タンパク質');
        $vitaminFoods = $babyfoods->where('category', 'ビタミン');
        $others = $babyfoods->where('category', 'その他');
        return view('contents', compact('userName','babyfoods', 'energyFoods', 'proteinFoods', 'vitaminFoods', 'others'));
    }

    public function store(Request $request)
    {
        // バリデーションした上で料理名を格納
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
        ]);
        // ログイン中のユーザーIDを追加して保存
        $validated['user_id'] = auth()->id();
        $validated['type'] = 'babyfood';
        // 保存したデータをDBに登録
        Dishes::create($validated);
        return back();
    }

    public function destroy($id)
    {
        // リクエストされたIDの料理を取得
        $dish = Dishes::find($id);
        // 認可処理
        if ($dish->user_id !== auth()->id()) {
            abort(403);
        }
        // 料理を削除
        $dish->delete();
        return back();
    }
}

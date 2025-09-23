<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;

class DishesController extends Controller
{
    public function index()
    {
        $dishes = Dishes::where('user_id', auth()->id())->get();
        return view('contents', compact('dishes'));
    }

    public function store(Request $request)
    {
        // バリデーションした上で料理名を格納
        $validated = $request->validate([
            'name' => 'required',
        ]);
        // ログイン中のユーザーIDを追加して保存
        $validated['user_id'] = auth()->id();
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

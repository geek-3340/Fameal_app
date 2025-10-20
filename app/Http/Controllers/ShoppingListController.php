<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    public function index()
    {
        $listItems=ShoppingList::where('user_id',auth()->id())->get();
        return view('contents',compact('listItems'));
    }

    public function store(Request $request)
    {
        // バリデーションした上で買い物リストを格納
        $validated = $request->validate([
            'name' => 'required',
        ]);
        // ログイン中のユーザーIDを追加して保存
        $validated['user_id'] = auth()->id();
        $validated['is_checked'] = false;
        // 保存したデータをDBに登録
        ShoppingList::create($validated);
        return back();
    }
}

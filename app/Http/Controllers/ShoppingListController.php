<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    public function index()
    {
        $listItems = ShoppingList::where('user_id', auth()->id())->get();
        $listItems = $listItems->sortByDesc('name')->sortBy('is_checked');
        return view('contents', compact('listItems'));
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

    public function checkBoxToggle(Request $request, $id)
    {
        $listItem = ShoppingList::where('id', $id)->where('user_id', auth()->id())->first();
        $listItem->is_checked = $request->is_checked;
        $listItem->save();
    }

    public function destroy()
    {
        ShoppingList::where('user_id', auth()->id())->where('is_checked', true)->delete();
        return back();
    }
}

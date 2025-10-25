<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menus;
use App\Models\MenusDishes;

class MenusDishesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'dish_id' => 'required|exists:dishes,id',
            'category' => 'required',
        ]);

        // 献立（menus）を日付＆ユーザーで取得 or 作成
        // 同じ日付のmenusがあれば取得、なければ新規作成
        $menu = Menus::firstOrCreate([
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);

        // 献立と料理の紐付け（menus_dishes）
        MenusDishes::create([
            'menu_id' => $menu->id,
            'dish_id' => $request->dish_id,
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', '献立を登録しました');
    }

    public function destroy($id)
    {
        $menusDish = MenusDishes::findOrFail($id);
        if ($menusDish->menu->user_id !== auth()->id()) {
            abort(403);
        }
        $menusDish->delete();
        return redirect()->back()->with('success', '料理を削除しました');
    }
}

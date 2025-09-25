<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusController extends Controller
{
    public function index()
    {
        // ログイン中のユーザーの料理を取得
        $dishes = Dishes::where('user_id', auth()->id())->get();
        // リレーションしたテーブルの情報を事前に取得し、中間テーブルの情報を取得
        // リレーション先に参照は、リレーションメソッド名でアクセスする
        $menus = MenusDishes::with('dish', 'menu')
            ->whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->get(); // リレーション先の情報を検索する場合はwhereHasを使い、検索には無名関数を使う
        $events = [];
        $menusByDate = [];
        foreach ($menus as $menu) {
            $events[] = [
                'title' => $menu->dish->name,
                'start' => $menu->menu->date,
            ];
            // $events=[['title'=>'料理名','start'=>'日付'],...];
            $date = $menu->menu->date;
            $menusByDate[$date][] = [
                'id' => $menu->id,
                'dish_name' => $menu->dish->name,
            ];
            // $menusByDate=['日付'=>[['id'=>'menus_dishesのid','dish_name'=>'料理名'],...],...];
        }
        return view('contents', compact('dishes', 'events', 'menusByDate'));
    }
}

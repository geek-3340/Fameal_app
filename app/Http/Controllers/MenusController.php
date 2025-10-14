<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusController extends Controller
{
    public function index()
    {
        // ルート名に応じて、料理の種類を振り分け
        $type = '';
        if (
            request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index')
        ) {
            $type = 'dish';
        } elseif (
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index')
        ) {
            $type = 'babyfood';
        }
        // ログイン中のユーザーの料理を取得
        $dishes = Dishes::where('user_id', auth()->id())->where('type', $type)->get();
        // リレーションしたテーブルの情報を事前に取得し、中間テーブルの情報を取得
        // リレーション先に参照は、リレーションメソッド名でアクセスする
        $menus = MenusDishes::with('dish', 'menu')
            ->whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('dish', function ($query) use ($type) {
                $query->where('type', $type);
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

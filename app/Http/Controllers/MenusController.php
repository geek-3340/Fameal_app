<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusController extends Controller
{
    public function index($category, $viewType)
    {
        // ルート名に応じて、料理の種類を振り分け
        $type = '';
        if ($category === 'dishes') {
            $type = 'dish';
        } elseif ($category === 'babyfoods') {
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
        $bg = "";
        $order = null;
        $menusByDate = [];
        foreach ($menus as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $bg = "#ffb700";
                    $order = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $bg = "#ff7d55";
                    $order = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $bg = "#91ff00";
                    $order = 2;
                    break;
                default:
                    $bg = "#bbbbbb";
                    $order = 3;
                    break;
            }
            $events[] = [
                'backgroundColor' => $bg,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'order' => $order,
                'category' => $menu->category,
            ];
            // $events=[['title'=>'料理名','start'=>'日付'],...];
            $date = $menu->menu->date;
            $menusByDate[$date][] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
            ];
            // $menusByDate=['日付'=>[['id'=>'menus_dishesのid','dish_name'=>'料理名'],...],...];
        }
        return view('contents', compact('viewType', 'dishes', 'type', 'events', 'menusByDate'));
    }

    public function edit($date)
    {
        $dishesMenu = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) {
            $query->where('type', 'dish');
        })->get();

        $babyFoodsMenu = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) {
            $query->where('type', 'babyfood');
        })->get();

        $dishesMenuData = [];
        $babyFoodsMenuData = [];
        $order = null;

        foreach ($dishesMenu as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $order = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $order = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $order = 2;
                    break;
                default:
                    $order = 3;
                    break;
            }
            $dishesMenuData[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'order' => $order,
            ];
        }

        foreach ($babyFoodsMenu as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $order = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $order = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $order = 2;
                    break;
                default:
                    $order = 3;
                    break;
            }
            $babyFoodsMenuData[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'order' => $order,
            ];
        }
        $dishesMenuData = collect($dishesMenuData)->sortBy('order')->values()->all();
        $babyFoodsMenuData = collect($babyFoodsMenuData)->sortBy('order')->values()->all();

        return response()->json([
            'dishesByDate' => $dishesMenuData,
            'babyFoodsByDate' => $babyFoodsMenuData,
        ]);
    }
}

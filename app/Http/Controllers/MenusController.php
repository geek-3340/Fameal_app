<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusController extends Controller
{
    public function index($category, $viewType) // 引数$viewTypeはそのままViewへ渡す
    {
        // 取得する料理種別の判別フラグ
        $type = '';
        if ($category === 'dishes') {
            $type = 'dish';
        } elseif ($category === 'babyfoods') {
            $type = 'babyfood';
        }

        // 料理データ取得（Viewへ渡す）
        $dishes = Dishes::where('user_id', auth()->id())->where('type', $type)->get();

        // 献立中間テーブルデータ取得
        $menus = MenusDishes::with('dish', 'menu')
            ->whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('dish', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();

        // fullcalendarに渡すデータ整形のための、空変数
        $menusForCalendarEvents = [];
        $dishBgColor = "";
        $dishDisplayOrder = null;

        // fullcalendar用に献立データを整形
        foreach ($menus as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $dishBgColor = "#ffb700";
                    $dishDisplayOrder = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $dishBgColor = "#ff7d55";
                    $dishDisplayOrder = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $dishBgColor = "#91ff00";
                    $dishDisplayOrder = 2;
                    break;
                default:
                    $dishBgColor = "#bbbbbb";
                    $dishDisplayOrder = 3;
                    break;
            }
            $menusForCalendarEvents[] = [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        }

        $method='index';
        $menusForCalendarEvents=$menus->map(function($menu){
            [$dishBgColor,$dishDisplayOrder]=$this->setDishBgColorAndDisplayOrder($method,$menu->dish->category);
            return [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        });

        // contents.blade.phpに整形済みデータを渡して描画
        return view('contents', compact('viewType', 'dishes', 'type', 'menusForCalendarEvents'));
    }

    // --------------------------------------------------------------------------------------------

    public function edit($date)
    {
        $dishesMenuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) {
            $query->where('type', 'dish');
        })->get();

        $babyFoodsMenuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) {
            $query->where('type', 'babyfood');
        })->get();

        $dishesMenuData = [];
        $babyFoodsMenuData = [];
        $dishDisplayOrder = null;

        foreach ($dishesMenuByDate as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $dishDisplayOrder = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $dishDisplayOrder = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $dishDisplayOrder = 2;
                    break;
                default:
                    $dishDisplayOrder = 3;
                    break;
            }
            $dishesMenuData[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
        }

        foreach ($babyFoodsMenuByDate as $menu) {
            switch ($menu->dish->category) {
                case '主食':
                case 'エネルギー':
                    $dishDisplayOrder = 0;
                    break;
                case '主菜':
                case 'タンパク質':
                    $dishDisplayOrder = 1;
                    break;
                case '副菜':
                case 'ビタミン':
                    $dishDisplayOrder = 2;
                    break;
                default:
                    $dishDisplayOrder = 3;
                    break;
            }
            $babyFoodsMenuData[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
        }

        // $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
        //     $query->where('user_id', auth()->id());
        //     $query->where('date', $date);
        // })->get();

        // $dishesMenuData=[];
        // $babyFoodsMenuData=[];
        // $method='edit';
        // foreach($menuByDate as $menu){
        //     if($menu->dish->type==='dish')
        //     $dishDisplayOrder=$this->setDishBgColorAndDisplayOrder($method,$menu->dish->category);
        //     $dishesMenuData[] = [
        //         'id' => $menu->id,
        //         'menu_category' => $menu->category,
        //         'dish_name' => $menu->dish->name,
        //         'dish_gram' => $menu->gram,
        //         'dish_recipe_url' => $menu->dish->recipe_url,
        //         'dishDisplayOrder' => $dishDisplayOrder,
        //     ];
        //     $babyFoodsMenuData[] = [
        //         'id' => $menu->id,
        //         'menu_category' => $menu->category,
        //         'dish_name' => $menu->dish->name,
        //         'dish_gram' => $menu->gram,
        //         'dish_recipe_url' => $menu->dish->recipe_url,
        //         'dishDisplayOrder' => $dishDisplayOrder,
        //     ];
        // }

        $dishesMenuData = collect($dishesMenuData)->sortBy('dishDisplayOrder')->values()->all();
        $babyFoodsMenuData = collect($babyFoodsMenuData)->sortBy('dishDisplayOrder')->values()->all();

        return response()->json([
            'dishesByDate' => $dishesMenuData,
            'babyFoodsByDate' => $babyFoodsMenuData,
        ]);
    }

    public function setDishBgColorAndDisplayOrder($method,$dishCategory){
        if($method==='index'){
            return match ($dishCategory) {
                '主食', 'エネルギー' => ['#ffb700', 0],
                '主菜', 'タンパク質' => ['#ff7d55', 1],
                '副菜', 'ビタミン' => ['#91ff00', 2],
                default => ['#bbbbbb', 3],
            };
        }elseif($method==='edit'){
            return match ($dishCategory) {
                '主食', 'エネルギー' => 0,
                '主菜', 'タンパク質' => 1,
                '副菜', 'ビタミン' => 2,
                default => 3,
            };
        }
    }
}

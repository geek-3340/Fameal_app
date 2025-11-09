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
            'gram' => 'nullable',
        ]);

        // 献立（menus）を日付＆ユーザーで取得 or 作成
        // 同じ日付のmenusがあれば取得、なければ新規作成
        $menu = Menus::firstOrCreate([
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);

        // 献立と料理の紐付け（menus_dishes）
        $menuDish = MenusDishes::create([
            'menu_id' => $menu->id,
            'dish_id' => $request->dish_id,
            'category' => $request->category,
            'gram' => $request->gram,
        ]);

        // dish情報も一緒に取得して返す
        $menuDish->load('dish'); // リレーションをロード（MenusDishesモデルで定義されている前提）

        $menuByAllDay = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('dish', function ($query) use ($menuDish) {
            $query->where('type', $menuDish->dish->type);
        })->get();

        $date = $request->date;
        $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($menuDish) {
            $query->where('type', $menuDish->dish->type);
        })->get();

        return response()->json(array_merge(
            $this->getLatestMenusForDate($menuByDate, $menuByAllDay),
            ['date' => $date]
        ));
    }

    public function destroy($id)
    {
        $menuDish = MenusDishes::findOrFail($id);
        if ($menuDish->menu->user_id !== auth()->id()) {
            abort(403);
        }

        $menuDish->load('dish'); // リレーションをロード（MenusDishesモデルで定義されている前提）

        $type = '';
        if ($menuDish->dish->type === 'dish') {
            $type = 'dish';
        } else {
            $type = 'babyfood';
        }

        $date = $menuDish->menu->date;

        $menuDish->delete();

        $menuByAllDay = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();


        $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();

        return response()->json(array_merge(
            $this->getLatestMenusForDate($menuByDate, $menuByAllDay),
            ['date' => $date]
        ));
    }

    private function getLatestMenusForDate($menuByDate, $menuByAllDay)
    {
        $modalLatestMenu = [];
        $calendarLatestMenu = [];

        foreach ($menuByDate as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $modalLatestMenu[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
        }
        foreach ($menuByAllDay as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $calendarLatestMenu[] = [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        }

        return [
            'modal' => collect($modalLatestMenu)->sortBy('dishDisplayOrder')->values(),
            'calendar' => collect($calendarLatestMenu)->sortBy('dishDisplayOrder')->values(),
        ];
    }

    private function setDishBgColorAndDisplayOrder($dishCategory)
    {
        return match ($dishCategory) {
            '主食', 'エネルギー' => ['#ffb700', 0],
            '主菜', 'タンパク質' => ['#ff7d55', 1],
            '副菜', 'ビタミン' => ['#91ff00', 2],
            default => ['#bbbbbb', 3],
        };
    }
}

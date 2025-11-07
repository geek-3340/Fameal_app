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

        $type = '';
        if ($menuDish->dish->type === 'dish') {
            $type = 'dish';
        } else {
            $type = 'babyfood';
        }

        $date = $request->date;

        $dishesMenu = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();

        $modalMenuUpdateData = [];
        $calendarMenuUpdateData = [];
        $order = null;
        $bg = '';

        foreach ($dishesMenu as $menu) {
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
            $modalMenuUpdateData[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'order' => $order,
            ];
            $calendarMenuUpdateData[] = [
                'backgroundColor' => $bg,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'order' => $order,
                'category' => $menu->category,
            ];
        }

        $modalMenuUpdateData = collect($modalMenuUpdateData)->sortBy('order')->values()->all();
        $calendarMenuUpdateData = collect($calendarMenuUpdateData)->sortBy('order')->values()->all();

        return response()->json([
            'modal' => $modalMenuUpdateData,
            'calendar' => $calendarMenuUpdateData,
        ]);
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

<?php

namespace App\Services;

use App\Models\MenusDishes;
use App\Models\ShoppingList;

class ShoppingListService
{
    public function createShoppingListFromIngredients($request)
    {
        // 指定期間の献立データを取得
        $startDate = $request->start;
        $endDate = $request->end;
        $menus = MenusDishes::with('menu', 'dish')->whereHas('menu', function ($query) use ($startDate, $endDate) {
            $query->where('user_id', auth()->id());
            $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        // 献立の材料を買い物リスト用に整形
        $ingredients = [];
        foreach ($menus as $menu) {
            if ($menu->dish->type === 'dish') {
                foreach ($menu->dish->ingredients as $ingredient)
                    $ingredients[] = [
                        'name' => $ingredient->name,
                        'user_id' => auth()->id(),
                        'is_checked' => false,
                    ];
            } elseif ($menu->dish->type === 'babyfood') {
                $ingredients[] = [
                    'name' => $menu->dish->name,
                    'user_id' => auth()->id(),
                    'is_checked' => false,
                ];
            }
        }

        // 重複排除処理
        $ingredients = collect($ingredients)
            ->unique('name')       // nameで重複排除
            ->values()             // キーを振り直す（[0,1,2...]）
            ->all();               // 配列に戻す

        // 一括保存
        ShoppingList::insert($ingredients);
    }
}

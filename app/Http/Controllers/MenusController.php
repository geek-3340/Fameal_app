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
        return view('contents', compact('category','viewType', 'dishes', 'events', 'menusByDate'));
    }
}

// 変更点：カレンダーのイベント配列に category に応じた backgroundColor / borderColor / textColor を追加します。FullCalendar はイベントオブジェクトのプロパティとしてこれらを受け取るので、ビュー側で JSON を受け取るだけで色が反映されます。

// 以下を既存ファイルに適用してください。

// <?php
// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Dishes;
// use App\Models\MenusDishes;

// class MenusController extends Controller
// {
//     public function index($category, $viewType)
//     {
//         // ルート名に応じて、料理の種類を振り分け
//         $type = '';
//         if ($category === 'dishes') {
//             $type = 'dish';
//         } elseif ($category === 'babyfoods') {
//             $type = 'babyfood';
//         }
//         // ログイン中のユーザーの料理を取得
//         $dishes = Dishes::where('user_id', auth()->id())->where('type', $type)->get();
//         // リレーションしたテーブルの情報を事前に取得し、中間テーブルの情報を取得
//         // リレーション先に参照は、リレーションメソッド名でアクセスする
//         $menus = MenusDishes::with('dish', 'menu')
//             ->whereHas('menu', function ($query) {
//                 $query->where('user_id', auth()->id());
//             })->whereHas('dish', function ($query) use ($type) {
//                 $query->where('type', $type);
//             })->get(); // リレーション先の情報を検索する場合はwhereHasを使い、検索には無名関数を使う
//         $events = [];
//         $menusByDate = [];
//         foreach ($menus as $menu) {
//             // カテゴリに応じた色を設定
//             if ($type === 'dish') {
//                 $bg = '#ffcf55';      // 料理用の背景色（既存スタイルに合わせた色）
//                 $border = '#ffcf55';
//                 $text = '#3d3d3d';
//             } else { // babyfood
//                 $bg = '#9be7a8';      // 離乳食用の背景色（例）
//                 $border = '#9be7a8';
//                 $text = '#3d3d3d';
//             }

//             $events[] = [
//                 'title' => $menu->dish->name,
//                 'start' => $menu->menu->date,
//                 'backgroundColor' => $bg,
//                 'borderColor' => $border,
//                 'textColor' => $text,
//                 'extendedProps' => [
//                     'category' => $category,
//                 ],
//             ];
//             // $events=[['title'=>'料理名','start'=>'日付','backgroundColor'=>'#fff',...],...];
//             $date = $menu->menu->date;
//             $menusByDate[$date][] = [
//                 'id' => $menu->id,
//                 'dish_name' => $menu->dish->name,
//             ];
//             // $menusByDate=['日付'=>[['id'=>'menus_dishesのid','dish_name'=>'料理名'],...],...];
//         }
//         return view('contents', compact('category','viewType', 'dishes', 'events', 'menusByDate'));
//     }
// }

// 備考：CSSで .fc .fc-h-event に固定色を指定していますが、イベントオブジェクトの backgroundColor はインラインスタイルとして反映されるため優先されます。必要なら className を付与して CSS 側でさらに細かく制御できます。


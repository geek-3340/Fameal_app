とても良い方向性です 👍
現在の `MenusController` と `MenusDishesController` は、ビジネスロジック・DB操作・ビュー/レスポンス構築が混ざっており、保守性が下がりやすい構造になっています。
ここでは「Service層」を導入して、**ControllerはHTTPリクエストの受け渡しに専念し、Serviceがビジネスロジックを担当する構成**の実装案を提示します。

---

## 🎯 目的

* Controller → HTTPの入り口。バリデーションやレスポンス生成のみ。
* Service → DBアクセス、業務ロジック、データ整形。
* Model → ORMによるデータ構造・リレーション定義。

---

## 📁 ディレクトリ構成（例）

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── MenusController.php
│   │   └── MenusDishesController.php
│   └── Requests/
│       └── StoreMenuDishRequest.php （バリデーション用FormRequest）
├── Models/
│   ├── Dishes.php
│   ├── Menus.php
│   └── MenusDishes.php
└── Services/
    ├── MenuService.php
    └── MenuDishService.php
```

---

## 🧩 1. `MenuService.php`（献立全体に関わる処理）

```php
<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\MenusDishes;

class MenuService
{
    /**
     * 献立一覧取得（カレンダー表示など）
     */
    public function getMenusWithDishes(string $category): array
    {
        $type = $this->getDishType($category);

        $dishes = Dishes::where('user_id', auth()->id())
            ->where('type', $type)
            ->get();

        $menus = MenusDishes::with(['dish', 'menu'])
            ->whereHas('menu', fn($q) => $q->where('user_id', auth()->id()))
            ->whereHas('dish', fn($q) => $q->where('type', $type))
            ->get();

        $events = $menus->map(function ($menu) {
            [$bg, $order] = $this->getColorAndOrder($menu->dish->category);
            return [
                'backgroundColor' => $bg,
                'title' => $menu->dish->name . ($menu->gram ? " {$menu->gram}g" : ''),
                'start' => $menu->menu->date,
                'order' => $order,
                'category' => $menu->category,
            ];
        })->toArray();

        return compact('dishes', 'events', 'type');
    }

    /**
     * 日付ごとの献立（大人用・離乳食用）取得
     */
    public function getMenusByDate(string $date): array
    {
        return [
            'dishesByDate' => $this->getMenusByTypeAndDate('dish', $date),
            'babyFoodsByDate' => $this->getMenusByTypeAndDate('babyfood', $date),
        ];
    }

    private function getMenusByTypeAndDate(string $type, string $date): array
    {
        $menus = MenusDishes::with(['dish', 'menu'])
            ->whereHas('menu', fn($q) => $q->where('user_id', auth()->id())->where('date', $date))
            ->whereHas('dish', fn($q) => $q->where('type', $type))
            ->get();

        $data = $menus->map(function ($menu) {
            [$bg, $order] = $this->getColorAndOrder($menu->dish->category);
            return [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'order' => $order,
            ];
        });

        return $data->sortBy('order')->values()->all();
    }

    private function getDishType(string $category): string
    {
        return match ($category) {
            'dishes' => 'dish',
            'babyfoods' => 'babyfood',
            default => '',
        };
    }

    private function getColorAndOrder(string $category): array
    {
        return match ($category) {
            '主食', 'エネルギー' => ['#ffb700', 0],
            '主菜', 'タンパク質' => ['#ff7d55', 1],
            '副菜', 'ビタミン' => ['#91ff00', 2],
            default => ['#bbbbbb', 3],
        };
    }
}
```

---

## 🧩 2. `MenuDishService.php`（1件の料理登録・削除を扱う）

```php
<?php

namespace App\Services;

use App\Models\Menus;
use App\Models\MenusDishes;

class MenuDishService
{
    public function storeMenuDish(array $data): array
    {
        // 献立作成または取得
        $menu = Menus::firstOrCreate([
            'date' => $data['date'],
            'user_id' => auth()->id(),
        ]);

        // 紐づけ作成
        $menuDish = MenusDishes::create([
            'menu_id' => $menu->id,
            'dish_id' => $data['dish_id'],
            'category' => $data['category'],
            'gram' => $data['gram'] ?? null,
        ]);

        return $this->getLatestMenusForDate($menu->date, $menuDish->dish->type);
    }

    public function deleteMenuDish(int $id): array
    {
        $menuDish = MenusDishes::findOrFail($id);
        if ($menuDish->menu->user_id !== auth()->id()) {
            abort(403);
        }

        $date = $menuDish->menu->date;
        $type = $menuDish->dish->type;

        $menuDish->delete();

        return $this->getLatestMenusForDate($date, $type);
    }

    private function getLatestMenusForDate(string $date, string $type): array
    {
        $menus = MenusDishes::with(['dish', 'menu'])
            ->whereHas('menu', fn($q) => $q->where('user_id', auth()->id())->where('date', $date))
            ->whereHas('dish', fn($q) => $q->where('type', $type))
            ->get();

        $modal = [];
        $calendar = [];

        foreach ($menus as $menu) {
            [$bg, $order] = $this->getColorAndOrder($menu->dish->category);

            $modal[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'order' => $order,
            ];

            $calendar[] = [
                'backgroundColor' => $bg,
                'title' => $menu->dish->name . ($menu->gram ? " {$menu->gram}g" : ''),
                'start' => $menu->menu->date,
                'order' => $order,
                'category' => $menu->category,
            ];
        }

        return [
            'modal' => collect($modal)->sortBy('order')->values()->all(),
            'calendar' => collect($calendar)->sortBy('order')->values()->all(),
        ];
    }

    private function getColorAndOrder(string $category): array
    {
        return match ($category) {
            '主食', 'エネルギー' => ['#ffb700', 0],
            '主菜', 'タンパク質' => ['#ff7d55', 1],
            '副菜', 'ビタミン' => ['#91ff00', 2],
            default => ['#bbbbbb', 3],
        };
    }
}
```

---

## 🧩 3. Controller側の変更例

### `MenusController`

```php
use App\Services\MenuService;

class MenusController extends Controller
{
    public function __construct(private MenuService $menuService) {}

    public function index($category, $viewType)
    {
        $result = $this->menuService->getMenusWithDishes($category);

        return view('contents', [
            'viewType' => $viewType,
            'dishes' => $result['dishes'],
            'type' => $result['type'],
            'events' => $result['events'],
        ]);
    }

    public function edit($date)
    {
        return response()->json($this->menuService->getMenusByDate($date));
    }
}
```

---

### `MenusDishesController`

```php
use App\Services\MenuDishService;

class MenusDishesController extends Controller
{
    public function __construct(private MenuDishService $menuDishService) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'dish_id' => 'required|exists:dishes,id',
            'category' => 'required',
            'gram' => 'nullable',
        ]);

        $response = $this->menuDishService->storeMenuDish($data);

        return response()->json($response);
    }

    public function destroy($id)
    {
        $response = $this->menuDishService->deleteMenuDish($id);

        return response()->json($response);
    }
}
```

---

## ✅ メリット

* Controllerが非常にシンプルに（責務分離）
* Serviceでロジックを一元管理でき、再利用・テスト容易化
* `getColorAndOrder()` のような共通ロジックを共通化可能

---

## 💡 発展案

* `MenuBaseService` を作り、共通メソッド（色・順序など）をまとめる。
* FormRequestを使ってControllerのバリデーションを分離。
* キャッシュ（`Cache::remember()`）導入でパフォーマンス最適化。

---

もし希望があれば、**Service層のテスト（PHPUnit / Pest）実装例** も提示できます。
→ 次に「テストコード例」も見たいですか？

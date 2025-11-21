<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\Ingredients;

class DishesController extends Controller
{
    public function index()
    {
        $user=auth()->user();
        $userName=$user->name;
        $dishes = Dishes::where('user_id', auth()->id())->where('type', 'dish')->get();
        $staples = $dishes->where('category', '主食');
        $mains = $dishes->where('category', '主菜');
        $sides = $dishes->where('category', '副菜');
        $others = $dishes->where('category', 'その他');
        return view('contents', compact('userName','dishes', 'staples', 'mains', 'sides', 'others'));
    }

    public function store(Request $request)
    {
        // バリデーションした上で料理名を格納
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'recipe_url' => 'nullable|url',
        ]);
        // ログイン中のユーザーIDを追加して保存
        $validated['user_id'] = auth()->id();
        $validated['type'] = 'dish';
        // 保存したデータをDBに登録
        Dishes::create($validated);
        return back();
    }

    public function edit($id)
    {
        $dish = Dishes::find($id);
        $ingredients = Ingredients::with('dish')->whereHas('dish', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        return response()->json([
            'dish' => $dish,
            'ingredients' => $ingredients,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'recipe_url' => 'nullable|url',
        ]);
        $validated['user_id'] = auth()->id();
        $validated['type'] = 'dish';
        $dish = Dishes::find($id);
        $dish->update($validated);
        return back();
    }

    public function destroy(Dishes $dish)
    {
        // 認可処理
        if ($dish->user_id !== auth()->id()) {
            abort(403);
        }
        // 料理を削除
        $dish->delete();
        return back();
    }
}

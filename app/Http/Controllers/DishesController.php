<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\Ingredients;

class DishesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userName = $user->name;
        $dishes = Dishes::where('user_id', auth()->id())->where('type', 'dish')->get();
        $staples = $dishes->where('category', '主食');
        $mains = $dishes->where('category', '主菜');
        $sides = $dishes->where('category', '副菜');
        $others = $dishes->where('category', 'その他');
        
        $response = compact('userName', 'dishes', 'staples', 'mains', 'sides', 'others');

        return view('contents', $response);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category' => 'required',
            'recipe_url' => 'nullable|url',
        ]);
        $validated['user_id'] = auth()->id();
        Dishes::create($validated);

        return back();
    }

    public function edit($id)
    {
        $dish = Dishes::find($id);
        $ingredients = Ingredients::with('dish')->whereHas('dish', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        $response = compact('dish', 'ingredients');

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category' => 'required',
            'recipe_url' => 'nullable|url',
        ]);
        $validated['user_id'] = auth()->id();
        
        $dish = Dishes::find($id);
        $dish->update($validated);

        return back();
    }

    public function destroy(Dishes $dish)
    {
        if ($dish->user_id !== auth()->id()) {
            abort(403);
        }
        $dish->delete();

        return back();
    }
}

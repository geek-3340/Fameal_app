<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    public function store(Request $request)
    {
        // バリデーションした上で料理名を格納
        $validated = $request->validate([
            'name' => 'required',
            'dish_id' => 'required',
        ]);
        Ingredients::create($validated);
        return back();
    }

    public function destroy($id)
    {
        $ingredient = Ingredients::find($id);
        $ingredient->delete();
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;

class DishesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $validated['user_id'] = auth()->id();
        $dishes = Dishes::create($validated);
        return back();
    }

    public function index()
    {
        $dishes = Dishes::All();
        return view('contents', compact('dishes'));
    }

    public function destroy($id)
    {
        $dish = Dishes::find($id);
        if ($dish && $dish->user_id === auth()->id()) {
            $dish->delete();
        }
        return back();
    }
}

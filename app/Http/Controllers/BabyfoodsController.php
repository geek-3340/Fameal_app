<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BabyfoodsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();
        $userName = $user->name;

        $babyfoods = Dishes::where('user_id', auth()->id())->where('type', 'babyfood')->get();

        $energyFoods = $babyfoods->where('category', 'エネルギー');
        $proteinFoods = $babyfoods->where('category', 'タンパク質');
        $vitaminFoods = $babyfoods->where('category', 'ビタミン');
        $others = $babyfoods->where('category', 'その他');

        $response = compact('userName', 'babyfoods', 'energyFoods', 'proteinFoods', 'vitaminFoods', 'others');

        return view('contents', $response);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:dish,babyfood',
            'category' => 'required|string|in:エネルギー, タンパク質,ビタミン,その他',
        ]);
        $validated['user_id'] = auth()->id();

        Dishes::create($validated);

        return back();
    }

    public function destroy(Dishes $babyfood)
    {
        $this->authorize('delete', $babyfood);
        $babyfood->delete();

        return back();
    }
}

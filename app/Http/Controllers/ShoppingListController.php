<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use App\Services\ShoppingListService;

class ShoppingListController extends Controller
{
    public function __construct(protected ShoppingListService $shoppingListService) {}

    public function index()
    {
        $user = auth()->user();
        $userName = $user->name;

        $listItems = ShoppingList::where('user_id', auth()->id())->get();
        $listItems = $listItems->sortByDesc('name')->sortBy('is_checked');

        $response = compact('userName', 'listItems');

        return view('contents', $response);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $validated['user_id'] = auth()->id();
        $validated['is_checked'] = false;

        ShoppingList::create($validated);

        return back();
    }

    public function ingredientsStore(Request $request)
    {
        $this->shoppingListService->createShoppingListFromIngredients($request);
        return back();
    }

    public function checkBoxToggle(Request $request, $id)
    {
        $listItem = ShoppingList::where('id', $id)->where('user_id', auth()->id())->first();
        $listItem->is_checked = $request->is_checked;
        $listItem->save();
    }

    public function destroy()
    {
        // where()でユーザーチェック済みのため、認可不要
        ShoppingList::where('user_id', auth()->id())->where('is_checked', true)->delete();
        return back();
    }
}

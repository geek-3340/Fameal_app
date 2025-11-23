<?php

namespace App\Http\Controllers;

use App\Services\MenusService;

class MenusController extends Controller
{
    public function __construct(protected MenusService $menusService) {}

    public function index($category, $viewType)
    {
        return view('contents', $this->menusService->dataFormatForIndex($category, $viewType));
    }

    public function edit($date)
    {
        return response()->json($this->menusService->dataFormatForEdit($date));
    }
}

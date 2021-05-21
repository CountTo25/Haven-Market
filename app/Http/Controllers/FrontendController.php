<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function home(Request $request): array
    {
        //get all the offerings
        return Shop::where('active', 1)->get()->toArray();
    }

    public function shopPage(string $shop, Request $request): array
    {
        return Shop::where('name', $shop)->with('items')->first()->toArray();
    }
}

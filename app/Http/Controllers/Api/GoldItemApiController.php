<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class GoldItemApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Gold Item API working ✅']);
    }
}

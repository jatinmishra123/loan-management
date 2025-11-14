<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CustomerApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Customer API working']);
    }
}

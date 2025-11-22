<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GoldPrice;

class GoldPriceApiController extends Controller
{
    /**
     * Get Latest Gold Price
     */
    public function latest()
    {
        $price = GoldPrice::latest()->first();

        return response()->json([
            'status' => true,
            'price'  => $price ? $price->price : 0,
            'updated_at' => $price ? $price->created_at : null
        ]);
    }
}

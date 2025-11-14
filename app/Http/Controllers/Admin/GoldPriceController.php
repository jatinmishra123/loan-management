<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldPrice;
use Illuminate\Http\Request;

class GoldPriceController extends Controller
{
    /**
     * Store new gold price
     */
    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        // Store the new price
        GoldPrice::create(['price' => $request->price]);

        return back()->with('success', 'Gold price updated successfully!');
    }

    /**
     * Edit gold price view
     */
    public function edit($id)
    {
        $price = GoldPrice::findOrFail($id);
        return view('admin.goldprice.edit', compact('price'));
    }

    /**
     * Update existing gold price
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $price = GoldPrice::findOrFail($id);
        $price->update(['price' => $request->price]);

        return redirect()->route('admin.dashboard')->with('success', 'Gold price updated successfully!');
    }

    /**
     * Delete old price
     */
    public function destroy($id)
    {
        GoldPrice::findOrFail($id)->delete();
        return back()->with('success', 'Gold price deleted successfully!');
    }

    /**
     * Get the latest price (used by dashboard)
     */
    public function latest()
    {
        $latestPrice = GoldPrice::latest()->first();
        return response()->json(['price' => $latestPrice ? $latestPrice->price : 0]);
    }
}

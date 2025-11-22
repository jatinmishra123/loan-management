<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GoldItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GoldItemApiController extends Controller
{
    /**
     * List all gold items admin-wise
     */
    public function index(Request $request)
    {
        if (!$request->admin_id) {
            return response()->json([
                'status' => false,
                'message' => 'admin_id is required'
            ], 400);
        }

        $goldItems = GoldItem::with('customer')
            ->where('admin_id', $request->admin_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $goldItems
        ]);
    }

    /**
     * Store gold item
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id'      => 'required|integer',
            'customer_id'   => 'required|exists:customers,id',
            'description'   => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'gross_weight'  => 'required|numeric|min:0',
            'stone_weight'  => 'required|numeric|min:0|lte:gross_weight',
            'purity'        => 'required|integer|min:1|max:24',
            'rate_per_gram' => 'required|numeric|min:0',
            'remarks'       => 'nullable|string|max:500',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // calculate weight & market value
        $net_weight = $request->gross_weight - $request->stone_weight;
        $market_value = $net_weight * $request->rate_per_gram;

        // image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gold-items', 'public');
        }

        $goldItem = GoldItem::create([
            'admin_id'      => $request->admin_id,
            'customer_id'   => $request->customer_id,
            'description'   => $request->description,
            'quantity'      => $request->quantity,
            'gross_weight'  => $request->gross_weight,
            'stone_weight'  => $request->stone_weight,
            'net_weight'    => $net_weight,
            'purity'        => $request->purity,
            'rate_per_gram' => $request->rate_per_gram,
            'market_value'  => $market_value,
            'remarks'       => $request->remarks,
            'image'         => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Gold item created successfully.',
            'data' => $goldItem
        ], 201);
    }

    /**
     * Show single gold item
     */
    public function show($id)
    {
        $item = GoldItem::with('customer')->find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Gold item not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    /**
     * Update gold item
     */
    public function update(Request $request, $id)
    {
        $goldItem = GoldItem::find($id);

        if (!$goldItem) {
            return response()->json([
                'status' => false,
                'message' => 'Gold item not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required|exists:customers,id',
            'description'   => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'gross_weight'  => 'required|numeric|min:0',
            'stone_weight'  => 'required|numeric|min:0|lte:gross_weight',
            'purity'        => 'required|integer|min:1|max:24',
            'rate_per_gram' => 'required|numeric|min:0',
            'remarks'       => 'nullable|string|max:500',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $net_weight = $request->gross_weight - $request->stone_weight;
        $market_value = $net_weight * $request->rate_per_gram;

        // image update
        $imagePath = $goldItem->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('gold-items', 'public');
        }

        $goldItem->update([
            'customer_id'   => $request->customer_id,
            'description'   => $request->description,
            'quantity'      => $request->quantity,
            'gross_weight'  => $request->gross_weight,
            'stone_weight'  => $request->stone_weight,
            'net_weight'    => $net_weight,
            'purity'        => $request->purity,
            'rate_per_gram' => $request->rate_per_gram,
            'market_value'  => $market_value,
            'remarks'       => $request->remarks,
            'image'         => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Gold item updated successfully.',
            'data' => $goldItem
        ]);
    }

    /**
     * Delete gold item
     */
    public function destroy($id)
    {
        $goldItem = GoldItem::find($id);

        if (!$goldItem) {
            return response()->json([
                'status' => false,
                'message' => 'Gold item not found'
            ], 404);
        }

        if ($goldItem->image && Storage::disk('public')->exists($goldItem->image)) {
            Storage::disk('public')->delete($goldItem->image);
        }

        $goldItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gold item deleted successfully.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoldItemController extends Controller
{
    /**
     * Show Gold Item List For Logged-in Admin
     */
    public function index()
    {
        $golditems = GoldItem::with('customer')
            ->where('admin_id', auth()->guard('admin')->id())
            ->latest()
            ->paginate(10);

        return view('admin.gold_items.index', compact('golditems'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $customers = Customer::where('admin_id', auth()->guard('admin')->id())
            ->select('id', 'brauser_name')
            ->get();

        return view('admin.gold_items.create', compact('customers'));
    }

    /**
     * Store Gold Item
     */
    public function store(Request $request)
    {
        $request->validate([
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

        $net_weight    = $request->gross_weight - $request->stone_weight;
        $market_value  = $net_weight * $request->rate_per_gram;

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gold-items', 'public');
        }

        GoldItem::create([
            'admin_id'      => auth()->guard('admin')->id(),
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

        return redirect()->route('admin.gold_items.index')
            ->with('success', 'Gold item added successfully.');
    }

    /**
     * Edit Gold Item
     */
    public function edit(GoldItem $gold_item)
    {
        if ($gold_item->admin_id !== auth()->guard('admin')->id()) {
            abort(403, "Unauthorized access");
        }

        $customers = Customer::where('admin_id', auth()->guard('admin')->id())
            ->select('id', 'brauser_name')
            ->get();

        return view('admin.gold_items.edit', compact('gold_item', 'customers'));
    }

    /**
     * Update Gold Item
     */
    public function update(Request $request, GoldItem $gold_item)
    {
        if ($gold_item->admin_id !== auth()->guard('admin')->id()) {
            abort(403, "Unauthorized access");
        }

        $request->validate([
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

        $net_weight   = $request->gross_weight - $request->stone_weight;
        $market_value = $net_weight * $request->rate_per_gram;

        // Image Update
        $imagePath = $gold_item->image;

        if ($request->hasFile('image')) {
            if ($gold_item->image && Storage::disk('public')->exists($gold_item->image)) {
                Storage::disk('public')->delete($gold_item->image);
            }

            $imagePath = $request->file('image')->store('gold-items', 'public');
        }

        $gold_item->update([
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

        return redirect()->route('admin.gold_items.index')
            ->with('success', 'Gold item updated successfully.');
    }

    /**
     * Delete Gold Item
     */
    public function destroy(GoldItem $gold_item)
    {
        if ($gold_item->admin_id !== auth()->guard('admin')->id()) {
            abort(403, "Unauthorized access");
        }

        if ($gold_item->image && Storage::disk('public')->exists($gold_item->image)) {
            Storage::disk('public')->delete($gold_item->image);
        }

        $gold_item->delete();

        return redirect()->route('admin.gold_items.index')
            ->with('success', 'Gold item deleted successfully.');
    }
}


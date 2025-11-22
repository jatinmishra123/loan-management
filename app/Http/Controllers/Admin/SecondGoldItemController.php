<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecondGoldItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SecondGoldItemController extends Controller
{
    /**
     * Display a listing of second gold items.
     */
    public function index()
    {
        $items = SecondGoldItem::latest()->paginate(10);

        return view('admin.second-appraisal.second_gold_items.index', compact('items'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        // Load Ledgers from second_appraisals table
        $folios = DB::table('second_appraisals')
            ->select('id', 'ledger_folio_no')
            ->orderBy('ledger_folio_no', 'ASC')
            ->get();

        return view('admin.second-appraisal.second_gold_items.create', compact('folios'));
    }

    /**
     * Store new item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ledger_folio_no' => 'required',
            'description'     => 'required|string',
            'quantity'        => 'required|numeric|min:1',
            'gross_weight'    => 'required|numeric',
            'stone_weight'    => 'nullable|numeric',
            'net_weight'      => 'required|numeric',
            'purity'          => 'required|numeric|min:1|max:24',
            'rate_per_gram'   => 'required|numeric',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remarks'         => 'nullable|string',
        ]);

        // Image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('uploads/second_gold_items', 'public');
        }

        // Save Item
        SecondGoldItem::create([
            'ledger_folio_no' => $request->ledger_folio_no,
            'description'     => $request->description,
            'quantity'        => $request->quantity,
            'gross_weight'    => $request->gross_weight,
            'stone_weight'    => $request->stone_weight,
            'net_weight'      => $request->net_weight,
            'purity'          => $request->purity,
            'rate_per_gram'   => $request->rate_per_gram,
            'image'           => $imagePath,
            'remarks'         => $request->remarks,
        ]);

        return redirect()->route('admin.second_gold_items.index')
            ->with('success', 'Second Gold Item Added Successfully!');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $item = SecondGoldItem::findOrFail($id);

        // Load folios again for dropdown
        $folios = DB::table('second_appraisals')
            ->select('id', 'ledger_folio_no')
            ->orderBy('ledger_folio_no', 'ASC')
            ->get();

        return view('admin.second-appraisal.second_gold_items.edit', compact('item', 'folios'));
    }

    /**
     * Update item.
     */
    public function update(Request $request, $id)
    {
        $item = SecondGoldItem::findOrFail($id);

        $request->validate([
            'ledger_folio_no' => 'required',
            'description'     => 'required|string',
            'quantity'        => 'required|numeric|min:1',
            'gross_weight'    => 'required|numeric',
            'stone_weight'    => 'nullable|numeric',
            'net_weight'      => 'required|numeric',
            'purity'          => 'required|numeric|min:1|max:24',
            'rate_per_gram'   => 'required|numeric',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remarks'         => 'nullable|string',
        ]);

        // Replace Image
        $imagePath = $item->image;

        if ($request->hasFile('image')) {

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')
                ->store('uploads/second_gold_items', 'public');
        }

        // Update item
        $item->update([
            'ledger_folio_no' => $request->ledger_folio_no,
            'description'     => $request->description,
            'quantity'        => $request->quantity,
            'gross_weight'    => $request->gross_weight,
            'stone_weight'    => $request->stone_weight,
            'net_weight'      => $request->net_weight,
            'purity'          => $request->purity,
            'rate_per_gram'   => $request->rate_per_gram,
            'image'           => $imagePath,
            'remarks'         => $request->remarks,
        ]);

        return redirect()->route('admin.second_gold_items.index')
            ->with('success', 'Second Gold Item Updated Successfully!');
    }

    /**
     * Delete item.
     */
public function destroy($id)
{
    $item = SecondGoldItem::findOrFail($id);

    if ($item->image && Storage::disk('public')->exists($item->image)) {
        Storage::disk('public')->delete($item->image);
    }

    $item->delete();

    return redirect()->route('admin.second_gold_items.index')
                     ->with('success', 'Gold Item Deleted Successfully!');
}

}

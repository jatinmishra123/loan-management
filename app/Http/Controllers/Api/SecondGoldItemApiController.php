<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SecondGoldItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SecondGoldItemApiController extends Controller
{
    /**
     * 📌 List all Second Gold Items
     */
    public function index()
    {
        $items = SecondGoldItem::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    /**
     * 📌 Get ledger folio list (dropdown)
     */
    public function folios()
    {
        $folios = DB::table('second_appraisals')
            ->select('id', 'ledger_folio_no')
            ->orderBy('ledger_folio_no', 'ASC')
            ->get();

        return response()->json([
            'status' => true,
            'folios' => $folios
        ]);
    }

    /**
     * 📌 Store new gold item
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

        $item = SecondGoldItem::create([
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

        return response()->json([
            'status' => true,
            'message' => 'Second Gold Item Created Successfully',
            'data' => $item
        ]);
    }

    /**
     * 📌 Show single item
     */
    public function show($id)
    {
        $item = SecondGoldItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    /**
     * 📌 Update gold item
     */
    public function update(Request $request, $id)
    {
        $item = SecondGoldItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ], 404);
        }

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

        $imagePath = $item->image;

        if ($request->hasFile('image')) {

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')
                ->store('uploads/second_gold_items', 'public');
        }

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

        return response()->json([
            'status' => true,
            'message' => 'Item Updated Successfully',
            'data' => $item
        ]);
    }

    /**
     * 📌 Delete Item
     */
    public function destroy($id)
    {
        $item = SecondGoldItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item Deleted Successfully'
        ]);
    }
}

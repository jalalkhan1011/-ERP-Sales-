<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'items.product']);

        if ($request->customer) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', "%{$request->customer}%"));
        }
        if ($request->product) {
            $query->whereHas('items.product', fn($q) => $q->where('name', 'like', "%{$request->product}%"));
        }
        if ($request->from && $request->to) {
            $query->whereBetween('sale_date', [$request->from, $request->to]);
        }

        $sales = $query->paginate(10);
        $total = $sales->sum('total_amount');

        return view('sale.index', compact('sales', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('sale.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'sale_date' => now(),
            'total_amount' => $request->total_amount
        ]);

        foreach ($request->items as $item) {
            $sale->items()->create($item);
        }

        if ($request->note) {
            $sale->notes()->create(['content' => $request->note]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $sale = Sale::with('items.product')->findOrFail($sale->id);
        $customers = Customer::all();
        $products = Product::all();

        $note = $sale->notes->first()->content ?? '';

        return view('sale.edit', compact('sale', 'customers', 'products', 'note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
        ]);

        $sale = Sale::findOrFail($sale->id);
        $sale->update([
            'customer_id' => $request->customer_id,
            'total_amount' => $request->total_amount,
        ]);


        $sale->items()->delete();


        foreach ($request->items as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'discount'   => $item['discount'],
                'subtotal'   => $item['subtotal'],
            ]);
        }

        $sale->notes()->delete();
        if (!empty($request->note)) {
            $sale->notes()->create([
                'content' => $request->note,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Sale updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            $sale->delete();
            DB::commit();
            return back()->with('error', 'Sale moved to trash');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('sales.index'))->with('error', 'Something went wrong');
        }
    }

    public function restore($id)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);
        $sale->restore();
        return redirect(route('sales.index'))->with('success', 'Sale restored successfully');
    }

    public function trash()
    {
        $sales = Sale::onlyTrashed()->paginate(10);
        return view('sale.trash', compact('sales'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            Product::create($request->only(['name', 'price']));
            DB::commit();
            return redirect(route('products.index'))->with('success', 'Product created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('products.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $product->update($request->only(['name', 'price']));
            DB::commit();
            return redirect(route('products.index'))->with('success', 'Product updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('products.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return back()->with('error', 'Product deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('products.index'))->with('error', 'Something went wrong');
        }
    }
}

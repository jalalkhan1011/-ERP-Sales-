<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            Customer::create($request->only(['name', 'email', 'phone']));
            DB::commit();
            return redirect(route('customers.index'))->with('success', 'Customer created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('customers.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
        ]);
        DB::beginTransaction();
        try {
            $customer->update($request->only(['name', 'email', 'phone']));
            DB::commit();
            return redirect(route('customers.index'))->with('success', 'Customer updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('customers.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();
            DB::commit();
            return back()->with('error', 'Customer deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('customers.index'))->with('error', 'Something went wrong');
        }
    }
}

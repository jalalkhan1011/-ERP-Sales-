@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Sales List</h3>

        <form method="GET" class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="customer" class="form-control" placeholder="Filter by Customer"
                    value="{{ request('customer') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="product" class="form-control" placeholder="Filter by Product"
                    value="{{ request('product') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-12 mt-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer->name }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}"
                                class="btn btn-warning btn-sm text-white">Edit</a>
                            <form method="POST" action="{{ route('sales.destroy', $sale->id) }}"
                                onsubmit="return confirm('Move to trash?')" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5>Total on this page: {{ number_format($total, 2) }}</h5>
        {{ $sales->links() }}
    </div>
@endsection

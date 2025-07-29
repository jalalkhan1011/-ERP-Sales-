@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Trashed Sales</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer->name }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                        <td><a href="{{ route('sales.restore', $sale->id) }}" class="btn btn-success btn-sm">Restore</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sales->links() }}
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Edit Product</h3>

        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Name<span class="text-danger"> *</span></label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                @error('name')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Price<span class="text-danger"> *</span></label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control"
                    required>
                @error('price')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection

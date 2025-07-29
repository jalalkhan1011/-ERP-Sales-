@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Add Customer</h3>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name<span class="text-danger"> *</span></label>
                <input type="text" name="name" class="form-control" required>
                @error('name')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
                @error('email')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
                @error('phone')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Customer</h3>

        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Name<span class="text-danger"> *</span></label>
                <input type="text" name="name" value="{{ $customer->name }}" class="form-control" required>
                @error('name')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $customer->email }}" class="form-control">
                @error('email')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control">
                @error('phone')
                    <div><span class="text-danger">{{ $message }}</span></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection

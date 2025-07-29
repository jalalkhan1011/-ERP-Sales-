@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Sale #{{ $sale->id }}</h3>

        <div id="alertBox"></div>

        <form id="saleEditForm">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}" {{ $sale->customer_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table" id="itemsTable">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $item)
                        <tr>
                            <td>
                                <select class="form-control product">
                                    @foreach ($products as $p)
                                        <option data-price="{{ $p->price }}" value="{{ $p->id }}"
                                            {{ $item->product_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" class="form-control qty" value="{{ $item->quantity }}"></td>
                            <td><input type="number" class="form-control price" value="{{ $item->price }}"></td>
                            <td><input type="number" class="form-control discount" value="{{ $item->discount }}"></td>
                            <td class="subtotal">{{ number_format($item->subtotal, 2) }}</td>
                            <td><button type="button" class="btn btn-danger remove">X</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-primary">+ Add Product</button>

            <h4 class="mt-3">Total: <span id="total">{{ number_format($sale->total_amount, 2) }}</span></h4>

            <textarea name="note" class="form-control" placeholder="Sale Note">{{ $note }}</textarea>

            <button type="submit" class="btn btn-success mt-2">Update Sale</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-2">Back</a>
        </form>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {

            let products = @json($products);

            // New Row Function
            function newRow() {
                let options = `<option value="">--Select--</option>`;
                options += products.map(p => `<option data-price="${p.price}" value="${p.id}">${p.name}</option>`)
                    .join('');
                return `<tr>
            <td><select class="form-control product">${options}</select></td>
            <td><input type="number" class="form-control qty" value="1"></td>
            <td><input type="number" class="form-control price" step="0.01"></td>
            <td><input type="number" class="form-control discount" value="0"></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-danger remove">X</button></td>
        </tr>`;
            }

            // Add Row
            $('#addRow').click(() => $('#itemsTable tbody').append(newRow()));

            // Auto Price
            $(document).on('change', '.product', function() {
                let price = $(this).find(':selected').data('price') || 0;
                let row = $(this).closest('tr');
                row.find('.price').val(price);
                updateRow(row);
            });

            // Qty, Price, Discount Change
            $(document).on('input', '.qty,.price,.discount', function() {
                updateRow($(this).closest('tr'));
            });

            // Remove Row
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                calcTotal();
            });

            function updateRow(row) {
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let discount = parseFloat(row.find('.discount').val()) || 0;
                let subtotal = (qty * price) - discount;
                row.find('.subtotal').text(subtotal.toFixed(2));
                calcTotal();
            }

            function calcTotal() {
                let total = 0;
                $('#itemsTable tbody tr').each(function() {
                    total += parseFloat($(this).find('.subtotal').text()) || 0;
                });
                $('#total').text(total.toFixed(2));
            }

            // AJAX Update
            $('#saleEditForm').submit(function(e) {
                e.preventDefault();

                let items = [];
                $('#itemsTable tbody tr').each(function() {
                    items.push({
                        product_id: $(this).find('.product').val(),
                        quantity: $(this).find('.qty').val(),
                        price: $(this).find('.price').val(),
                        discount: $(this).find('.discount').val(),
                        subtotal: $(this).find('.subtotal').text()
                    });
                });

                $.ajax({
                    url: "{{ route('sales.update', $sale->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        customer_id: $('select[name=customer_id]').val(),
                        total_amount: $('#total').text(),
                        items: items,
                        note: $('textarea[name=note]').val()
                    },
                    success: function(res) {
                        $('#alertBox').html(
                            `<div class="alert alert-success">✅ ${res.message}</div>`);
                        setTimeout(() => window.location.href = "{{ route('sales.index') }}",
                            1000);
                    },
                    error: function() {
                        $('#alertBox').html(
                            `<div class="alert alert-danger">❌ Error updating sale</div>`);
                    }
                });
            });

        });
    </script>
@endpush

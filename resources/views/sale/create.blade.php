@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Create Sale</h3>
        <form id="saleForm">
            @csrf
            <div class="mb-3">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
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
                <tbody></tbody>
            </table>
            <button type="button" id="addRow" class="btn btn-primary">+ Add Product</button>

            <h4 class="mt-3">Total: <span id="total">0.00</span></h4>

            <textarea name="note" class="form-control" placeholder="Sale Note"></textarea>

            <button type="submit" class="btn btn-success mt-2">Save Sale</button>
        </form>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {

            let products = @json($products);

            // ✅ New Row Function
            function newRow() {
                let options = `<option value="">-- Select Product --</option>`;
                options += products.map(p => `<option data-price="${p.price}" value="${p.id}">${p.name}</option>`)
                    .join('');
                return `<tr>
            <td><select class="form-control product">${options}</select></td>
            <td><input type="number" class="form-control qty" value="1" min="1"></td>
            <td><input type="number" class="form-control price" step="0.01"></td>
            <td><input type="number" class="form-control discount" value="0" min="0"></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-danger remove">X</button></td>
        </tr>`;
            }

            // ✅ Add Row Button
            $('#addRow').click(function() {
                $('#itemsTable tbody').append(newRow());
            });

            // ✅ On Product Change → Auto Price + Subtotal
            $(document).on('change', '.product', function() {
                let price = parseFloat($(this).find(':selected').data('price')) || 0;
                let row = $(this).closest('tr');
                row.find('.price').val(price);
                updateRowSubtotal(row);
            });

            // ✅ Quantity, Price, Discount Change → Update Subtotal
            $(document).on('input', '.qty, .price, .discount', function() {
                let row = $(this).closest('tr');
                updateRowSubtotal(row);
            });

            // ✅ Remove Row
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                calcTotal();
            });

            // ✅ Update Row Subtotal Function
            function updateRowSubtotal(row) {
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let discount = parseFloat(row.find('.discount').val()) || 0;
                let subtotal = (qty * price) - discount;
                row.find('.subtotal').text(subtotal.toFixed(2));
                calcTotal();
            }

            // ✅ Calculate Total
            function calcTotal() {
                let total = 0;
                $('#itemsTable tbody tr').each(function() {
                    total += parseFloat($(this).find('.subtotal').text()) || 0;
                });
                $('#total').text(total.toFixed(2));
            }

            // ✅ AJAX Submit Form
            $('#saleForm').submit(function(e) {
                e.preventDefault();

                let items = [];
                $('#itemsTable tbody tr').each(function() {
                    items.push({
                        product_id: $(this).find('.product').val(),
                        quantity: $(this).find('.qty').val(),
                        price: $(this).find('.price').val(),
                        discount: $(this).find('.discount').val(),
                        subtotal: $(this).find('.subtotal').text(),
                    });
                });

                $.post("{{ route('sales.store') }}", {
                    _token: "{{ csrf_token() }}",
                    customer_id: $('select[name=customer_id]').val(),
                    total_amount: $('#total').text(),
                    items: items,
                    note: $('textarea[name=note]').val()
                }, function(res) {
                    alert('✅ Sale Saved Successfully!');
                    window.location.href = "{{ route('sales.index') }}";
                }).fail(function() {
                    alert('❌ Error saving sale!');
                });
            });

        });
    </script>
@endpush

@extends('layouts.master')

@section('title', 'Edit Purchase')

@section('content')
<div class="container">
    <h1>Edit Purchase</h1>
    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="order_id">Order</label>
            <select id="order_id" name="order_id" class="form-control">
                <option value="">Select Order</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" data-product="{{ $order->product->name }}" data-supplier="{{ $order->supplier->name }}" data-price="{{ $order->purchase_price }}"
                        {{ $order->id == $purchase->order_id ? 'selected' : '' }}>
                        {{ 'Order No ' . $order->id }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product_name">Product</label>
            <input type="text" id="product_name" class="form-control" value="{{ $purchase->order->product->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="supplier_name">Supplier</label>
            <input type="text" id="supplier_name" class="form-control" value="{{ $purchase->order->supplier->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="purchase_price">Purchase Price</label>
            <input type="number" id="purchase_price" class="form-control" value="{{ $purchase->order->purchase_price }}" readonly>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $purchase->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="total_price">Total Price</label>
            <input type="number" id="total_price" class="form-control" value="{{ $purchase->total_price }}" readonly>
        </div>
        <div class="form-group">
            <label for="amount_given">Amount Given</label>
            <input type="number" id="amount_given" name="amount_given" class="form-control" value="{{ $purchase->amount_given }}" required>
        </div>
        <div class="form-group">
            <label for="change_returned">Change Returned</label>
            <input type="number" id="change_returned" class="form-control" value="{{ $purchase->change_returned }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Update Purchase</button>
    </form>
</div>

<script>
    document.getElementById('order_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const product = selectedOption.getAttribute('data-product');
        const supplier = selectedOption.getAttribute('data-supplier');
        const price = selectedOption.getAttribute('data-price');

        document.getElementById('product_name').value = product;
        document.getElementById('supplier_name').value = supplier;
        document.getElementById('purchase_price').value = price;
        calculateTotalPrice();
    });

    document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
    document.getElementById('amount_given').addEventListener('input', calculateChangeReturned);

    function calculateTotalPrice() {
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('purchase_price').value;
        const totalPrice = quantity * price;

        document.getElementById('total_price').value = totalPrice;
    }

    function calculateChangeReturned() {
        const totalPrice = document.getElementById('total_price').value;
        const amountGiven = document.getElementById('amount_given').value;
        const changeReturned = amountGiven - totalPrice;

        document.getElementById('change_returned').value = changeReturned >= 0 ? changeReturned : 0;
    }

    // Trigger the calculations on page load in case of existing values
    calculateTotalPrice();
    calculateChangeReturned();
</script>
@endsection

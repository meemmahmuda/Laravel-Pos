@extends('layouts.master')

@section('title', 'Edit Sale')

@section('content')
<div class="container">
    <h1>Edit Sale</h1>
    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ $sale->customer_name }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ $sale->address }}" required>
        </div>
        <div class="form-group">
            <label for="phone_no">Phone No</label>
            <input type="text" id="phone_no" name="phone_no" class="form-control" value="{{ $sale->phone_no }}" required>
        </div>
        <div class="form-group">
            <label for="product_id">Product</label>
            <select id="product_id" name="product_id" class="form-control" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-code="{{ $product->code }}" data-category="{{ $product->category->name }}" data-price="{{ $product->selling_price }}"
                        @if($product->id == $sale->product_id) selected @endif>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" class="form-control" readonly value="{{ $sale->product->name }}">
        </div>
        <div class="form-group">
            <label for="product_code">Product Code</label>
            <input type="text" id="product_code" class="form-control" readonly value="{{ $sale->product->code }}">
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" class="form-control" readonly value="{{ $sale->product->category->name }}">
        </div>
        <div class="form-group">
            <label for="selling_price">Selling Price</label>
            <input type="number" id="selling_price" class="form-control" readonly value="{{ $sale->selling_price }}">
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" id="discount" name="discount" class="form-control" value="{{ $sale->discount }}">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $sale->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="total_price">Total Price</label>
            <input type="number" id="total_price" name="total_price" class="form-control" value="{{ $sale->total_price }}" readonly>
        </div>
        <div class="form-group">
            <label for="money_taken">Money Taken</label>
            <input type="number" id="money_taken" name="money_taken" class="form-control" value="{{ $sale->money_taken }}" required>
        </div>
        <div class="form-group">
            <label for="money_returned">Money Returned</label>
            <input type="number" id="money_returned" name="money_returned" class="form-control" value="{{ $sale->money_returned }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Update Sale</button>
    </form>
</div>

<script>
    document.getElementById('product_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const productName = selectedOption.getAttribute('data-name');
        const productCode = selectedOption.getAttribute('data-code');
        const category = selectedOption.getAttribute('data-category');
        const sellingPrice = parseFloat(selectedOption.getAttribute('data-price'));

        document.getElementById('product_name').value = productName;
        document.getElementById('product_code').value = productCode;
        document.getElementById('category').value = category;
        document.getElementById('selling_price').value = sellingPrice;
        calculateTotalPrice();
    });

    document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
    document.getElementById('discount').addEventListener('input', calculateTotalPrice);
    document.getElementById('money_taken').addEventListener('input', calculateMoneyReturned);

    function calculateTotalPrice() {
        const sellingPrice = parseFloat(document.getElementById('selling_price').value) || 0;
        const quantity = parseInt(document.getElementById('quantity').value) || 0;
        const discountPercentage = parseFloat(document.getElementById('discount').value) || 0;

        const subtotal = sellingPrice * quantity;
        const discountAmount = (discountPercentage / 100) * subtotal;
        let totalPrice = subtotal - discountAmount;
        if (totalPrice < 0) {
            totalPrice = 0;
        }

        document.getElementById('total_price').value = totalPrice;
        calculateMoneyReturned();
    }

    function calculateMoneyReturned() {
        const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
        const moneyTaken = parseFloat(document.getElementById('money_taken').value) || 0;
        const moneyReturned = moneyTaken - totalPrice;
        
        document.getElementById('money_returned').value = moneyReturned >= 0 ? moneyReturned : 0;
    }

    // Initialize calculations on page load
    calculateTotalPrice();
</script>

@endsection

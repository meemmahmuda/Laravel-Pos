@extends('layouts.master')

@section('title', 'Purchase Invoice')

@section('content')
<div class="container">
    <h1>Purchase Invoice</h1>
    <div class="invoice-details">
        <p><strong>Order No:</strong> {{ 'Order No ' . $purchase->order->id }}</p>
        <p><strong>Product Name:</strong> {{ $purchase->order->product->name }}</p>
        <p><strong>Supplier Name:</strong> {{ $purchase->order->supplier->name }}</p>
        <p><strong>Quantity:</strong> {{ $purchase->quantity }}</p>
        <p><strong>Total Price:</strong> {{ $purchase->total_price }}</p>
    </div>
    <button onclick="window.print()" class="btn btn-primary">Print</button>
</div>
@endsection

@extends('layouts.master')

@section('title', 'Sales List')

@section('content')
<div class="container">
    <h1>Sales List</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">Add New Sale</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Customer Contact No.</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->address }}</td>
                    <td>{{ $sale->phone_no }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->discount }}%</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('sales.invoice', $sale->id) }}" target="_blank" class="btn btn-info">Print Invoice</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

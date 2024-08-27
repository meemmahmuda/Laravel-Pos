@extends('layouts.master')

@section('content')

<div class="container">
<h1>Sales Returns</h1>
    <a href="{{ route('sales_returns.create') }}" class="btn btn-primary">Add Sales Return</a>
    <table class="table">
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Product Name</th>
                <th>Quantity Returned</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesReturns as $return)
                <tr>
                    <td>{{ $return->sale->id }}</td>
                    <td>{{ $return->sale->product->name }}</td>
                    <td>{{ $return->quantity }}</td>
                    <td>{{ $return->total_price }}</td>
                    <td>
                        <form action="{{ route('sales_returns.destroy', $return->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

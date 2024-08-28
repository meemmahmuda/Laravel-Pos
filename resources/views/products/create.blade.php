@extends('layouts.master')
@section('title', 'Create Products List')

@section('content')
    <div class="container">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="code">Product Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="purchase_price">Purchase Price</label>
                <input type="number" name="purchase_price" id="purchase_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <input type="number" name="selling_price" id="selling_price" class="form-control" required>
            </div>
            <!-- <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" >
            </div> -->
            <button type="submit" class="btn btn-primary">Save Product</button>
        </form>
    </div>
@endsection

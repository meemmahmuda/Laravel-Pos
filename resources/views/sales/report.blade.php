<!-- resources/views/sales/report.blade.php -->

@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Sales Report by Category</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Total Units Sold</th>
                <th>Total Sales</th>
                <th>Total Discounts</th>
                <th>Net Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categoryReport as $category => $report)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ $report['total_units'] }}</td>
                    <td>${{ number_format($report['total_sales'], 2) }}</td>
                    <td>${{ number_format($report['total_discounts'], 2) }}</td>
                    <td>${{ number_format($report['net_sales'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

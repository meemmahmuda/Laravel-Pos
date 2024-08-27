@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Income Statement</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Purchase Amount (TK)</th>
                <th>Sales Amount (TK)</th>
                <th>Profit/Loss (TK)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incomeStatement as $statement)
                <tr>
                    <td>{{ $statement['date'] }}</td>
                    <td>{{ number_format($statement['purchase_amount'], 2) }}</td>
                    <td>{{ number_format($statement['sales_amount'], 2) }}</td>
                    <td>{{ number_format($statement['profit_or_loss'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No transactions available.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Profit/Loss</th>
                <th>{{ number_format($totalProfitOrLoss, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

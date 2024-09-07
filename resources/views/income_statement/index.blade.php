@extends('layouts.master')

@section('title', 'Income Statement')

@section('content')
<div class="container">

    <!-- Month selection form -->
    <form action="{{ route('income_statement.index') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="month">Select Month:</label>
            <select style="width: 200px" name="month" id="month" class="form-control" onchange="this.form.submit()">
                @for ($i = 0; $i < 12; $i++)
                    @php
                        $month = now()->subMonths($i)->format('Y-m');
                    @endphp
                    <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                    </option>
                @endfor
            </select>
        </div>
    </form>

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
                    <td colspan="4">No transactions available for the selected month.</td>
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

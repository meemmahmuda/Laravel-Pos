<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SalesReturn;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected month from the request, default to the current month
        $selectedMonth = $request->input('month', date('Y-m'));

        // Filter sales by selected month
        $sales = Sale::selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter purchases by selected month
        $purchases = Purchase::selectRaw('DATE(created_at) as date, SUM(total_price) as total_purchases')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->groupBy('date')
            ->get();

        // Filter sales returns by selected month
        $salesReturns = SalesReturn::selectRaw('DATE(created_at) as date, SUM(total_price) as total_returns')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->groupBy('date')
            ->get();

        // Prepare data for the income statement
        $incomeStatement = $sales->map(function ($sale) use ($purchases, $salesReturns) {
            $purchase = $purchases->firstWhere('date', $sale->date);
            $purchaseAmount = $purchase ? $purchase->total_purchases : 0;

            $salesReturn = $salesReturns->firstWhere('date', $sale->date);
            $salesReturnAmount = $salesReturn ? $salesReturn->total_returns : 0;

            // Adjust the sales amount by subtracting the sales returns
            $adjustedSalesAmount = $sale->total_sales - $salesReturnAmount;

            $profitOrLoss = $adjustedSalesAmount - $purchaseAmount;

            return [
                'date' => $sale->date,
                'purchase_amount' => $purchaseAmount,
                'sales_amount' => $adjustedSalesAmount,
                'profit_or_loss' => $profitOrLoss,
            ];
        });

        // Calculate total profit or loss
        $totalProfitOrLoss = $incomeStatement->sum('profit_or_loss');

        // Pass the selected month and income statement to the view
        return view('income_statement.index', compact('incomeStatement', 'totalProfitOrLoss', 'selectedMonth'));
    }
}

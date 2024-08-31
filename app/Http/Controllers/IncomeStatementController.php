<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SalesReturn; // Include the SalesReturn model
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{
    public function index()
    {
        // Get all sales, purchases, and sales returns, grouped by date
        $sales = Sale::selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
            ->groupBy('date')
            ->get();

        $purchases = Purchase::selectRaw('DATE(created_at) as date, SUM(total_price) as total_purchases')
            ->groupBy('date')
            ->get();

        $salesReturns = SalesReturn::selectRaw('DATE(created_at) as date, SUM(total_price) as total_returns')
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
                'profit_or_loss' => $,
            ];
        });

        // Calculate total profit or loss
        $totalProfitOrLoss = $incomeStatement->sum('profit_or_loss');

        return view('income_statement.index', compact('incomeStatement', 'totalProfitOrLoss'));
    }
}

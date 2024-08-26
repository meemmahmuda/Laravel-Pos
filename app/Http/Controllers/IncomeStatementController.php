<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{
    public function index()
    {
        // Get all sales and purchases, grouped by date
        $sales = Sale::selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
            ->groupBy('date')
            ->get();

        $purchases = Purchase::selectRaw('DATE(created_at) as date, SUM(total_price) as total_purchases')
            ->groupBy('date')
            ->get();

        // Prepare data for the income statement
        $incomeStatement = $sales->map(function ($sale) use ($purchases) {
            $purchase = $purchases->firstWhere('date', $sale->date);
            $purchaseAmount = $purchase ? $purchase->total_purchases : 0;

            $profitOrLoss = $sale->total_sales - $purchaseAmount;

            return [
                'date' => $sale->date,
                'purchase_amount' => $purchaseAmount,
                'sales_amount' => $sale->total_sales,
                'profit_or_loss' => $profitOrLoss,
            ];
        });

        return view('income_statement.index', compact('incomeStatement'));
    }
}

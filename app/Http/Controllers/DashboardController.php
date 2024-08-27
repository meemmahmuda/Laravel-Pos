<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SalesReturn;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();  
        $suppliers = Supplier::count();  
        $products = Product::count();  
        $orders = Order::count();  
        $purchases = Purchase::count();  
        $sales = Sale::count();  
        $salesreturn = SalesReturn::count();  
    
        return view('dashboard', compact('categories', 'suppliers', 'products', 'orders', 'purchases', 'sales', 'salesreturn'));
    }
}



<?php

namespace App\Http\Controllers;
use App\Models\Sale;
use App\Models\Product;
use PDF;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product->stock <= 0) {
            return redirect()->back()->withErrors(['product_id' => 'The selected product is out of stock.']);
        }

        if ($request->quantity > $product->stock) {
            return redirect()->back()->withErrors(['quantity' => 'The quantity cannot be greater than the available stock.']);
        }
    
        $sellingPrice = $product->selling_price;
        $quantity = $request->quantity;
        $discountPercentage = $request->discount;
    
        // Calculate the subtotal
        $subtotal = $sellingPrice * $quantity;
        
        // Calculate the discount amount
        $discountAmount = ($discountPercentage / 100) * $subtotal;
        
        // Calculate the total price after discount
        $totalPrice = $subtotal - $discountAmount;
        if ($totalPrice < 0) {
            $totalPrice = 0;
        }
    
        // Calculate money returned
        $moneyTaken = $request->money_taken;
        $moneyReturned = $moneyTaken - $totalPrice;
        if ($moneyReturned < 0) {
            $moneyReturned = 0;
        }

    // Create the sale record
    Sale::create([
        'customer_name' => $request->customer_name,
        'address' => $request->address,
        'phone_no' => $request->phone_no,
        'product_id' => $request->product_id,
        'quantity' => $quantity,
        'selling_price' => $sellingPrice, 
        'total_price' => $totalPrice,
        'discount' => $discountPercentage,
        'money_taken' => $moneyTaken,
        'money_returned' => $moneyReturned,
    ]);

    // Update the product stock
    $product->decrement('stock', $quantity);

    return redirect()->route('sales.index')->with('success', 'Sale created successfully!');


        // Update product stock
        $product->update([
            'stock' => $product->stock - $request->quantity,
        ]);


        

        // Generate an invoice (implement your own logic)
        // $this->generateInvoice($sale);

        return redirect()->route('sales.index')->with('success', 'Sale completed and invoice generated.');
    }

    public function edit(Sale $sale)
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $product = Product::find($request->product_id);

        if ($product->stock <= 0) {
            return redirect()->back()->withErrors(['product_id' => 'The selected product is out of stock.']);
        }

        if ($request->quantity > $product->stock) {
            return redirect()->back()->withErrors(['quantity' => 'The quantity cannot be greater than the available stock.']);
        }
        
        $sellingPrice = $product->selling_price;
        $quantity = $request->quantity;
        $discountPercentage = $request->discount;
    
        // Calculate the subtotal
        $subtotal = $sellingPrice * $quantity;
        
        // Calculate the discount amount
        $discountAmount = ($discountPercentage / 100) * $subtotal;
        
        // Calculate the total price after discount
        $totalPrice = $subtotal - $discountAmount;
        if ($totalPrice < 0) {
            $totalPrice = 0;
        }
        
        // Calculate money returned
        $moneyTaken = $request->money_taken;
        $moneyReturned = $moneyTaken - $totalPrice;
        if ($moneyReturned < 0) {
            $moneyReturned = 0;
        }
    
        // Update the sale record
        $sale->update([
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'selling_price' => $sellingPrice, 
            'total_price' => $totalPrice,
            'discount' => $discountPercentage, 
            'money_taken' => $moneyTaken,
            'money_returned' => $moneyReturned,
        ]);
    
        // Update the product stock
        $product->update([
            'stock' => $product->stock - $request->quantity,
        ]);
    
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }
    

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    public function printInvoice($id)
    {
        $sale = Sale::findOrFail($id);

        // Load your PDF view and pass the sale data
        $pdf = PDF::loadView('sales.invoice', ['sale' => $sale]);

        return $pdf->stream('invoice.pdf'); // or use ->download('invoice.pdf') to force download
    }
}


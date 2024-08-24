<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
  
    public function index()
{
    $purchases = Purchase::with(['order.product', 'order.supplier'])->get();
    return view('purchases.index', compact('purchases'));
}

public function printInvoice(Purchase $purchase)
{
    return view('purchases.invoice', compact('purchase'));
}


    public function create()
    {
        $orders = Order::all();
        return view('purchases.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'quantity' => 'required|integer',
        ]);

        $order = Order::findOrFail($request->order_id);

        $totalPrice = $order->purchase_price * $request->quantity;

        // Update product stock
        $product = Product::findOrFail($order->product_id);
        $product->stock += $request->quantity;
        $product->save();

        Purchase::create([
            'order_id' => $order->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $orders = Order::all();
        return view('purchases.edit', compact('purchase', 'orders'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'order_id' => 'required',
            'quantity' => 'required|integer',
        ]);

        $order = Order::findOrFail($request->order_id);

        $totalPrice = $order->purchase_price * $request->quantity;

        // Update product stock
        $product = Product::findOrFail($order->product_id);
        $product->stock += $request->quantity;
        $product->save();

        $purchase->update([
            'order_id' => $order->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $product = Product::findOrFail($purchase->order->product_id);
        $product->stock -= $purchase->quantity;
        $product->save();

        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}

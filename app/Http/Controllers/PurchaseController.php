<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Category;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('product.category')->get();
        $totalPurchasesPrice = Purchase::sum('total_price');
        $totalPurchasesDuePrice = Purchase::sum('due_price');
        return view('purchases.index', compact('purchases', 'totalPurchasesPrice', 'totalPurchasesDuePrice'));
    }

    public function create()
    {
        $products = Product::all();
        $categories = Category::all(); // Fetch all categories
        return view('purchases.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'company_name' => 'nullable|string',
            'pay_price' => 'nullable|numeric',
        ]);

        $total_price = $request->price * $request->quantity;
        $pay_price = $request->pay_price ?? 0;
        $due_price = $total_price - $pay_price;

        $purchase = Purchase::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
            'total_price' => $total_price,
            'company_name' => $request->company_name,
            'pay_price' => $pay_price,
            'due_price' => $due_price,
        ]);

        $product = Product::find($request->product_id);

        // Calculate new stock and average price
        $newStock = $product->stock + $request->quantity;
        $newPrice = (($product->price * $product->stock) + ($request->price * $request->quantity)) / $newStock;

        $product->stock = $newStock;
        $product->price = $newPrice;
        $product->total_price = $newPrice * $newStock;
        $product->save();

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $products = Product::all();
        $categories = Category::all(); // Fetch all categories
        return view('purchases.edit', compact('purchase', 'products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'company_name' => 'nullable|string',
            'pay_price' => 'nullable|numeric',
        ]);

        $purchase = Purchase::findOrFail($id);
        $originalProduct = $purchase->product_id;
        $originalQuantity = $purchase->quantity;
        $originalPrice = $purchase->price;

        $total_price = $request->price * $request->quantity;
        $pay_price = $request->pay_price ?? 0;
        $due_price = $total_price - $pay_price;

        // Update purchase details
        $purchase->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
            'total_price' => $total_price,
            'company_name' => $request->company_name,
            'pay_price' => $pay_price,
            'due_price' => $due_price,
        ]);

        if ($originalProduct != $request->product_id) {
            // Revert stock and price for the original product
            $originalProductModel = Product::find($originalProduct);
            $originalProductModel->stock -= $originalQuantity;
            $originalProductModel->total_price = $originalProductModel->price * $originalProductModel->stock;
            $originalProductModel->save();

            // Update stock and price for the new product
            $newProductModel = Product::find($request->product_id);
            $newStock = $newProductModel->stock + $request->quantity;
            $newProductModel->stock = $newStock;
            $newProductModel->total_price = $newProductModel->price * $newStock;
            $newProductModel->save();
        } else {
            // Update stock and price for the existing product
            $product = Product::find($request->product_id);
            $product->stock += $request->quantity - $originalQuantity;

            // Adjust the product price proportionally
            if ($product->stock > 0) {
                $product->price = ($product->price * $product->stock + $request->price * $request->quantity - $originalPrice * $originalQuantity) / $product->stock;
            } else {
                $product->price = 0; // Handle case when stock becomes zero to avoid division by zero
            }

            $product->total_price = $product->price * $product->stock;
            $product->save();
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $product = Product::find($purchase->product_id);
        $product->stock -= $purchase->quantity; // Adjust stock based on removed quantity
        $product->save();
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }    

    public function monthly()
    {
        $purchases = Purchase::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(total_price) as total')
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->get();

        foreach ($purchases as $purchase) {
            $purchase->month_name = Carbon::create()->month($purchase->month)->format('F');
        }
        
        return view('purchases.monthly', compact('purchases'));
    }

    public function getMonthlyDetails($year, $month)
    {
        $purchases = Purchase::whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->with('product')
                            ->get();

        return response()->json($purchases);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Expense;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->get();
        $totalSalesPrice = Sale::sum('total_price');
        $totalSalesDuePrice = Sale::sum('due_price');
        return view('sales.index', compact('sales', 'totalSalesPrice', 'totalSalesDuePrice'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'customer_name' => 'nullable|string',
            'pay_price' => 'nullable|numeric',
        ]);

        $total_price = $request->price * $request->quantity;
        $pay_price = $request->pay_price ?? 0;
        $due_price = $total_price - $pay_price;

        $sale = Sale::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
            'total_price' => $total_price,
            'customer_name' => $request->customer_name,
            'pay_price' => $pay_price,
            'due_price' => $due_price,
        ]);

        $product = Product::find($request->product_id);
        $product->stock -= $request->quantity;
        $product->save();

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'customer_name' => 'nullable|string',
            'pay_price' => 'nullable|numeric',
        ]);

        $sale = Sale::findOrFail($id);
        $originalProduct = $sale->product_id;
        $originalQuantity = $sale->quantity;
        $total_price = $request->price * $request->quantity;
        $pay_price = $request->pay_price ?? 0;
        $due_price = $total_price - $pay_price;

        $sale->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
            'total_price' => $total_price,
            'customer_name' => $request->customer_name,
            'pay_price' => $pay_price,
            'due_price' => $due_price,
        ]);

        if ($originalProduct != $request->product_id) {
            $originalProductModel = Product::find($originalProduct);
            $originalProductModel->stock += $originalQuantity;
            $originalProductModel->save();

            $newProductModel = Product::find($request->product_id);
            $newProductModel->stock -= $request->quantity;
            $newProductModel->save();
        } else {
            $product = Product::find($request->product_id);
            $product->stock += $originalQuantity - $request->quantity;
            $product->save();
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $product = Product::find($sale->product_id);
        $product->stock += $sale->quantity; // Adjust stock based on removed quantity
        $product->save();
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    public function monthly()
    {
        $sales = Sale::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(total_price) as total')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get();

        foreach ($sales as $sale) {
            $sale->month_name = Carbon::create()->month($sale->month)->format('F');
        }

        return view('sales.monthly', compact('sales'));
    }

    public function getMonthlyDetails($year, $month)
    {
        $sales = Sale::whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->with('product')
                    ->get();

        return response()->json($sales);
    }

    public function dailyReport()
    {
        $today = Carbon::today();
        $sales = Sale::whereDate('date', $today)->get();
        $expenses = Expense::whereDate('date', $today)->get();

        $totalSales = $sales->sum('total_price');
        $totalExpenses = $expenses->sum('amount');
        $summary = $totalSales - $totalExpenses;

        return view('sales.daily', compact('sales', 'expenses', 'totalSales', 'totalExpenses', 'summary'));
    }
}

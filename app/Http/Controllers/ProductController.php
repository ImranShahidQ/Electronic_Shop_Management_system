<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $totalProductsPrice = Product::sum('total_price');
        return view('products.index', compact('products', 'totalProductsPrice'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $product = Product::create($request->all());

        $category = $product->category;
        if ($category) {
            $accountDetail = $category->accountDetails()->latest('date')->first();
            
            if ($accountDetail) {
                $newDuePrice = $accountDetail->due_price + $product->total_price;
                $accountDetail->update(['due_price' => $newDuePrice]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $oldTotalPrice = $product->total_price;

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'date' => $request->date,
            'total_price' => $request->price * $request->stock,
        ]);
    
        $category = $product->category;
        if ($category) {
            $accountDetail = $category->accountDetails()->latest('date')->first();
            
            if ($accountDetail) {
                $newDuePrice = $accountDetail->due_price - $oldTotalPrice + $product->total_price;
                $accountDetail->update(['due_price' => $newDuePrice]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->purchases()->count() > 0 || $product->sales()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Cannot delete product because it has related sales or purchases.');
        }

        $category = $product->category;
        if ($category) {
            $accountDetail = $category->accountDetails()->latest('date')->first();
            
            if ($accountDetail) {
                $newDuePrice = $accountDetail->due_price - $product->total_price;
                $accountDetail->update(['due_price' => $newDuePrice]);
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get categories with their products
        $categories = Category::with(['products.sales', 'products.purchases'])
            ->get()
            ->map(function ($category) {
                // Calculate total sales quantity and list products by category
                $category->total_sales_quantity = $category->products->sum(function ($product) {
                    return $product->sales->sum('quantity');
                });

                // Calculate total purchases quantity and list products by category
                $category->total_purchases_quantity = $category->products->sum(function ($product) {
                    return $product->purchases->sum('quantity');
                });

                // Count total products and stock by category
                // $category->total_products = $category->products->count();
                $category->total_stock = $category->products->sum('stock');

                // List products with their sales and purchases
                $category->products = $category->products->map(function ($product) {
                    $product->total_sales_quantity = $product->sales->sum('quantity');
                    $product->total_purchases_quantity = $product->purchases->sum('quantity');
                    return $product;
                });

                return $category;
            });

        return view('dashboard', compact('categories'));
    }
}

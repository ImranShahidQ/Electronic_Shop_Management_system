<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AccountDetail;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products;
        $totalPrice = $products->sum('total_price');
        return response()->json(['products' => $products, 'totalPrice' => $totalPrice]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category because it has related products.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function accountDetails(Category $category)
    {
        $accountDetails = $category->accountDetails()->orderBy('date')->get();
        $latestEntryDuePrice = $accountDetails->last() ? $accountDetails->last()->due_price : null;
        return view('categories.account_details', compact('category', 'accountDetails', 'latestEntryDuePrice'));
    }

    public function storeAccountDetails(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'total_price' => 'required|numeric',
            'paid_price' => 'required|numeric',
            'due_price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Fetch the latest entry for the category
        $latestEntry = AccountDetail::where('category_id', $request->category_id)
                                    ->orderBy('date', 'desc')
                                    ->first();

        // If there's a latest entry, calculate new due price
        if ($latestEntry) {
            $totalPrice = $latestEntry->due_price;
        } else {
            $totalPrice = $request->total_price;
        }

        $accountDetail = AccountDetail::create([
            'category_id' => $request->category_id,
            'total_price' => $totalPrice,
            'paid_price' => $request->paid_price,
            'due_price' => $totalPrice - $request->paid_price,
            'date' => $request->date,
        ]);

        return redirect()->route('categories.accountDetails', $request->category_id)->with('success', 'Account details added successfully.');
    }
}

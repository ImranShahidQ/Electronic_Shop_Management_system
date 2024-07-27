<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OldCustomer;

class OldAccountController extends Controller
{
    public function index()
    {
        $oldCustomers = OldCustomer::all();
        $totalDuesPrice = OldCustomer::sum('due_price');
        return view('oldAccounts.index', compact('oldCustomers', 'totalDuesPrice'));
    }

    public function create()
    {
        return view('oldAccounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'product_name' => 'required|string',
            'total_price' => 'required|numeric',
            'pay_price' => 'required|numeric',
            'due_price' => 'required|numeric',
        ]);

        OldCustomer::create($request->all());

        return redirect()->route('oldAccounts.index')->with('success', 'Account created successfully.');
    }

    public function edit($id)
    {
        $oldCustomer = OldCustomer::findOrFail($id);
        return view('oldAccounts.edit', compact('oldCustomer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'product_name' => 'required|string',
            'total_price' => 'required|numeric',
            'pay_price' => 'required|numeric',
            'due_price' => 'required|numeric',
        ]);

        $oldCustomer = OldCustomer::findOrFail($id);
        $oldCustomer->update($request->all());

        return redirect()->route('oldAccounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $oldCustomer = OldCustomer::findOrFail($id);
        $oldCustomer->delete();

        return redirect()->route('oldAccounts.index')->with('success', 'Account deleted successfully.');
    }
}

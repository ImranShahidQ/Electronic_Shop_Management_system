<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        $totalExpensesPrice = Expense::sum('amount');
        return view('expenses.index', compact('expenses', 'totalExpensesPrice'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        Expense::create($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }

    public function monthly()
    {
        $expenses = Expense::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(amount) as total')
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->get();

        foreach ($expenses as $expense) {
            $expense->month_name = Carbon::create()->month($expense->month)->format('F');
        }

        return view('expenses.monthly', compact('expenses'));
    }

    public function getMonthlyDetails($year, $month)
    {
        $expenses = Expense::whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->get();

        return response()->json($expenses);
    }
}

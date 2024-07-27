<!-- resources/views/expenses/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Expenses</h1>
        <h3 style="color: green">Total Expenses Price: {{ $totalExpensesPrice }}</h3>
    </div>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-2">Add Expense</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $key=> $expense)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->amount }} RS</td>
                    <td>{{ $expense->date }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

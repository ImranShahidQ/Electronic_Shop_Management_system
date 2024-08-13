@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Account Details for {{ $category->name }}</h1>
    </div>
    <form action="{{ route('categories.storeAccountDetails') }}" method="POST">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id }}">
        <div class="form-group">
            <label for="total_price">Total Price</label>
            <input type="number" name="total_price" id="total_price" class="form-control" step="0.01" 
                value="{{ $latestEntryDuePrice ?? old('total_price') }}" required>
        </div>
        <div class="form-group">
            <label for="paid_price">Paid Price</label>
            <input type="number" name="paid_price" id="paid_price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="due_price">Due Price</label>
            <input type="number" name="due_price" id="due_price" class="form-control" step="0.01" required readonly>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Account Details</button>
    </form>

    <h2 class="mt-4">All Account Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Price</th>
                <th>Paid Price</th>
                <th>Due Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountDetails as $detail)
                <tr>
                    <td>{{ $detail->date }}</td>
                    <td>{{ $detail->total_price }}</td>
                    <td>{{ $detail->paid_price }}</td>
                    <td>{{ $detail->due_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('paid_price').addEventListener('input', function() {
            const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
            const paidPrice = parseFloat(this.value) || 0;
            const duePrice = totalPrice - paidPrice;
            document.getElementById('due_price').value = duePrice.toFixed(2);
        });
    </script>
@endsection

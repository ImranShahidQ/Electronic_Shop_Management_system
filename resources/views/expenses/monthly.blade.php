@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Monthly Expenses Report</h1>
        <table id="dataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Expenses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $expense->year }}</td>
                        <td>
                            <button class="btn btn-primary view-expense-details" data-year="{{ $expense->year }}"
                                data-month="{{ $expense->month }}">
                                {{ $expense->month }} - {{ $expense->month_name }}
                            </button>
                        </td>
                        <td>{{ $expense->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="monthlyExpenseDetails" style="display: none;">
            <h2>Expenses Report for <span id="expenseReportMonth"></span> - <span id="expenseReportYear"></span></h2>
            <table id="expenseDetailsTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="expenseDetailsBody">
                    <!-- Details will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewExpenseDetailsButtons = document.querySelectorAll('.view-expense-details');

        viewExpenseDetailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const year = this.getAttribute('data-year');
                const month = this.getAttribute('data-month');
                const reportMonth = this.textContent;

                fetch(`/expenses/monthly/${year}/${month}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('expenseReportYear').textContent = year;
                        document.getElementById('expenseReportMonth').textContent =
                            reportMonth;

                        const detailsBody = document.getElementById('expenseDetailsBody');
                        detailsBody.innerHTML = '';

                        data.forEach(expense => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${new Date(expense.created_at).toLocaleDateString()}</td>
                            <td>${expense.description}</td>
                            <td>${expense.amount}</td>
                        `;
                            detailsBody.appendChild(row);
                        });

                        document.getElementById('monthlyExpenseDetails').style.display =
                            'block';
                    });
            });
        });
    });
</script>

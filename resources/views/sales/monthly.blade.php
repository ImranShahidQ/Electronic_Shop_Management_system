@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Monthly Sales Report</h1>
    <table id="dataTable" class="table table-striped">
        <thead>
            <tr>
                <th>Year</th>
                <th>Month</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->year }}</td>
                <td>
                    <button class="btn btn-primary view-details" data-year="{{ $sale->year }}" data-month="{{ $sale->month }}">
                        {{ $sale->month }} - {{ $sale->month_name }}
                    </button>
                </td>
                <td>{{ $sale->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="monthlyDetails" style="display: none;">
        <h2>Sales Report for <span id="reportMonth"></span> - <span id="reportYear"></span></h2>
        <table id="detailsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody id="detailsBody">
                <!-- Details will be loaded here -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewDetailsButtons = document.querySelectorAll('.view-details');

        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function () {
                const year = this.getAttribute('data-year');
                const month = this.getAttribute('data-month');
                const reportMonth = this.textContent;

                fetch(`/sales/monthly/${year}/${month}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('reportYear').textContent = year;
                        document.getElementById('reportMonth').textContent = reportMonth;

                        const detailsBody = document.getElementById('detailsBody');
                        detailsBody.innerHTML = '';

                        data.forEach(sale => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${new Date(sale.created_at).toLocaleDateString()}</td>
                                <td>${sale.product.name}</td>
                                <td>${sale.quantity}</td>
                                <td>${sale.price}</td>
                                <td>${sale.total_price}</td>
                            `;
                            detailsBody.appendChild(row);
                        });

                        document.getElementById('monthlyDetails').style.display = 'block';
                    });
            });
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Monthly Purchases Report</h1>
    <table id="dataTable" class="table table-striped">
        <thead>
            <tr>
                <th>Year</th>
                <th>Month</th>
                <th>Total Purchases</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->year }}</td>
                <td>
                    <button class="btn btn-primary view-purchase-details" data-year="{{ $purchase->year }}" data-month="{{ $purchase->month }}">
                        {{ $purchase->month }} - {{ $purchase->month_name }}
                    </button>
                </td>
                <td>{{ $purchase->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="monthlyPurchaseDetails" style="display: none;">
        <h2>Purchases Report for <span id="purchaseReportMonth"></span> - <span id="purchaseReportYear"></span></h2>
        <table id="purchaseDetailsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody id="purchaseDetailsBody">
                <!-- Details will be loaded here -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewPurchaseDetailsButtons = document.querySelectorAll('.view-purchase-details');

        viewPurchaseDetailsButtons.forEach(button => {
            button.addEventListener('click', function () {
                const year = this.getAttribute('data-year');
                const month = this.getAttribute('data-month');
                const reportMonth = this.textContent;

                fetch(`/purchases/monthly/${year}/${month}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('purchaseReportYear').textContent = year;
                        document.getElementById('purchaseReportMonth').textContent = reportMonth;

                        const detailsBody = document.getElementById('purchaseDetailsBody');
                        detailsBody.innerHTML = '';

                        data.forEach(purchase => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${new Date(purchase.date).toLocaleDateString()}</td>
                                <td>${purchase.product.name}</td>
                                <td>${purchase.quantity}</td>
                                <td>${purchase.price}</td>
                                <td>${purchase.total_price}</td>
                            `;
                            detailsBody.appendChild(row);
                        });

                        document.getElementById('monthlyPurchaseDetails').style.display = 'block';
                    });
            });
        });
    });
</script>
@endsection
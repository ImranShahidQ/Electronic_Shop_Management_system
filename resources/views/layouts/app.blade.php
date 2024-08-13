<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Raheem Electronics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            background-color: #f8f9fa;
        }

        .navbar,
        .sidebar {
            background-color: #000;
        }

        .navbar a {
            color: #fff !important;
        }

        .sidebar a {
            color: #fff;
        }

        .sidebar a.active {
            background-color: #333;
        }

        #app {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .container-fluid {
            flex: 1;
            display: flex;
        }

        .row {
            flex: 1;
            display: flex;
        }

        .sidebar {
            flex: 0 0 200px;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            overflow-y: auto;
            background-color: #fff;
            padding: 20px;
        }

        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            flex-shrink: 0;
        }

        .dropdown-menu a.dropdown-item.text-primary {
            color: #007bff !important;
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid #ddd;
            margin: 1rem 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <h1 style="font-size: 1em; font-weight: bold; color: blue;">Al-Raheem Electronics</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-primary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'categories.index' ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    Categories
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'products.index' ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    Products
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'sales.index' ? 'active' : '' }}" href="{{ route('sales.index') }}">
                                    Sales
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'purchases.index' ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                                    Purchases
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'expenses.index' ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                                    Expenses
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'claims.index' ? 'active' : '' }}" href="{{ route('claims.index') }}">
                                    Claim Records
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'oldAccounts.index' ? 'active' : '' }}" href="{{ route('oldAccounts.index') }}">
                                    Old Accounts
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a href="{{ route('daily.report') }}" class="nav-link {{ Route::currentRouteName() == 'daily.report' ? 'active' : '' }}">
                                    Daily Report
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'sales.monthly' ? 'active' : '' }}" href="{{ route('sales.monthly') }}">
                                    Sales Per Month
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'purchases.monthly' ? 'active' : '' }}" href="{{ route('purchases.monthly') }}">
                                    Purchases Per Month
                                </a>
                            </li>
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'expenses.monthly' ? 'active' : '' }}" href="{{ route('expenses.monthly') }}">
                                    Expenses Per Month
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>                

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
                    @yield('content')
                </main>
            </div>
        </div>

        <footer>
            <div class="text-center p-3">
                © 2024 Al-Raheem Electronics
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @yield('script')
</body>

</html>

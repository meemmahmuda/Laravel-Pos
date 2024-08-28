<div class="d-flex" style="height: 700px;">
        <!-- Sidebar -->
    <div class="bg-dark text-white " style="width: 13rem;">
        <div class="p-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white">
                        <i class="fa fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link text-white">
                        <i class="fa fa-layer-group"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('suppliers.index') }}" class="nav-link text-white">
                        <i class="fa fa-id-card"></i> Suppliers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link text-white">
                        <i class="fa fa-cube"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link text-white">
                        <i class="fa fa-shopping-cart"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('purchases.index') }}" class="nav-link text-white">
                        <i class="fa-solid fa-bag-shopping"></i> Purchases
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sales.index') }}" class="nav-link text-white">
                        <i class="fa fa-dollar-sign"></i> Sales
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sales_returns.index') }}" class="nav-link text-white">
                        <i class="fa fa-arrow-circle-right"></i> Sales Return
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('income_statement.index') }}" class="nav-link text-white">
                        <i class="fa fa-chart-line"></i> Income Statement
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
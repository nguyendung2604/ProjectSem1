<div class="col-md-3 col-lg-2 px-0">
    <div class="sidebar">
        <nav class="nav flex-column">
            <a href="?tab=dashboard" class="nav-link <?php echo $active_tab === 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-user"></i>My Profile
            </a>
            <a href="?tab=users" class="nav-link <?php echo $active_tab === 'users' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>User Management
            </a>
            <a href="?tab=orders" class="nav-link <?php echo $active_tab === 'orders' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>Orders Management
            </a>
            <a href="?tab=products" class="nav-link <?php echo $active_tab === 'products' ? 'active' : ''; ?>">
                <i class="fas fa-box"></i>Products
            </a>
            <a href="?tab=insert_products" class="nav-link <?php echo $active_tab === 'insert_products' ? 'active' : ''; ?>">
                <i class="fas fa-plus"></i>Insert Products
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-palette"></i>Insert Image & Color
            </a>
            <a href="?tab=categories" class="nav-link <?php echo $active_tab === 'categories' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i>Category Management
            </a>
            <a href="?tab=brands" class="nav-link <?php echo $active_tab === 'brands' ? 'active' : ''; ?>">
                <i class="fas fa-trademark"></i>Brand Management
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </nav>
    </div>
</div>
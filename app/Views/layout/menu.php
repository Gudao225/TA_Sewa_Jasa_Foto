<?php $session = \Config\Services::session(); ?>
<?php if (session()->get('isLoggedIn')): ?>
    <li class="menu-header">Main Menu</li>
    <li><a class="nav-link" href="<?= base_url() ?>"><i class="fas fa-home"></i> <span>Halaman Utama</span></a></li>
    <li><a class="nav-link" href="<?= base_url('sewa') ?>"><i class="fas fa-address-book"></i> <span>Sewa</span></a></li>
    <li><a class="nav-link" href="<?= base_url('orders') ?>"><i class="fas fa-shopping-cart"></i> <span>Pesanan Saya</span></a></li>

    <?php if(session()->get('role') === 'admin'): ?>
        <li class="menu-header">Admin Menu</li>
        <li><a class="nav-link" href="<?= base_url('admin') ?>"><i class="fas fa-user-cog"></i> <span>Dashboard Admin</span></a></li>
        <li><a class="nav-link" href="<?= base_url('admin/orders') ?>"><i class="fas fa-tasks"></i> <span>Kelola Pesanan</span></a></li>
        <li><a class="nav-link" href="<?= base_url('admin/services') ?>"><i class="fas fa-list"></i> <span>Kelola Layanan</span></a></li>
    <?php endif; ?>

    <li><a class="nav-link" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
<?php else: ?>
    <li><a class="nav-link" href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt"></i> <span>Login</span></a></li>
    <li><a class="nav-link" href="<?= base_url('register') ?>"><i class="fas fa-user-plus"></i> <span>Register</span></a></li>
<?php endif; ?>
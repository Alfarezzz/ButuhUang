<?php
$activePage = basename($_SERVER['PHP_SELF']);
?>
<aside class="dashboard-sidebar">
    <a href="pinjaman.php" class="sidebar-menu-item <?= $activePage == 'pinjaman.php' ? 'active' : '' ?>">
        <img src="assets/images/icon-pinjaman.svg" alt="Pinjaman" class="sidebar-icon">
        <span>Pinjaman</span>
    </a>
    <a href="limit.php" class="sidebar-menu-item <?= $activePage == 'limit.php' ? 'active' : '' ?>">
        <img src="assets/images/icon-limit.svg" alt="Limit Pinjam" class="sidebar-icon">
        <span>Limit Pinjam</span>
    </a>
    <a href="tagihan.php" class="sidebar-menu-item <?= $activePage == 'tagihan.php' ? 'active' : '' ?>">
        <img src="assets/images/icon-tagihan.svg" alt="Tagihan" class="sidebar-icon">
        <span>Tagihan</span>
    </a>
    <a href="cara-pinjam.php" class="sidebar-menu-item <?= $activePage == 'cara-pinjam.php' ? 'active' : '' ?>">
        <img src="assets/images/icon-cara.svg" alt="Cara Pinjam" class="sidebar-icon">
        <span>Cara Pinjam</span>
    </a>
</aside>

<?php
$currentUser = getLoggedInUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <a href="index.php" class="nav-brand">
        <img src="assets/images/logo.png" alt="Logo ButuhUang" style="height: 46px; width: auto; object-fit: contain; display: block;">
        <span style="font-size: 1.8rem; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; line-height: 1;">Butuh<span style="color:#ffffff;">Uang</span></span>
    </a>

    <ul class="nav-links">
        <li><a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">BERANDA</a></li>
        <li><a href="simulasi.php" class="<?= $currentPage == 'simulasi.php' ? 'active' : '' ?>">SIMULASI</a></li>
        <li><a href="faq.php" class="<?= $currentPage == 'faq.php' ? 'active' : '' ?>">FAQ</a></li>
        <li><a href="pinjaman.php" class="<?= in_array($currentPage, ['pinjaman.php', 'limit.php', 'tagihan.php', 'cara-pinjam.php']) ? 'active' : '' ?>">PINJAMAN</a></li>
        <li>
            <?php if ($currentUser): ?>
                <a href="handlers/logout.php" class="btn-nav-auth" style="background:#0284c7;">Logout</a>
            <?php else: ?>
                <a href="auth.php" class="btn-nav-auth">Masuk</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>

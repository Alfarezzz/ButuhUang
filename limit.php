<?php
$pageTitle = "Limit Pinjaman";
require_once __DIR__ . '/includes/header.php';
requireAuth();

$user = getLoggedInUser();
$formattedLimit = number_format($user['limit_sisa'], 0, ',', '.');
?>

<div class="dashboard-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="dashboard-content" style="max-width: 900px;">
        <!-- LIMIT HERO CARD -->
        <div class="limit-card-hero">
            <h3>Limit Pinjaman(Rp)</h3>
            <div class="limit-nominal-display"><?= $formattedLimit ?></div>

            <div class="limit-badges-row">
                <!-- BADGE 1 -->
                <div class="limit-badge-item">
                    <div class="limit-badge-icon">
                        <svg style="width:28px; height:28px; fill:none; stroke:currentColor; stroke-width:2;" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <span>Tenor 3-12 bulan</span>
                </div>

                <!-- BADGE 2 -->
                <div class="limit-badge-item">
                    <div class="limit-badge-icon">
                        <svg style="width:28px; height:28px; fill:none; stroke:currentColor; stroke-width:2;" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                            <circle cx="9" cy="10" r="2"></circle>
                            <line x1="15" y1="8" x2="17" y2="8"></line>
                            <line x1="15" y1="12" x2="17" y2="12"></line>
                            <line x1="7" y1="16" x2="17" y2="16"></line>
                        </svg>
                    </div>
                    <span>Syarat KTP</span>
                </div>

                <!-- BADGE 3 -->
                <div class="limit-badge-item">
                    <div class="limit-badge-icon">
                        <svg style="width:28px; height:28px; fill:none; stroke:currentColor; stroke-width:2;" viewBox="0 0 24 24">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <span>Bunga Maks 10%</span>
                </div>
            </div>
        </div>

        <!-- QUICK SHORTCUTS -->
        <div class="limit-shortcuts-grid">
            <a href="tagihan.php" class="shortcut-card-link">
                <img src="assets/images/icon-tagihan.svg" alt="Tagihan" class="shortcut-icon-img">
                <span>Tagihan</span>
            </a>

            <a href="pinjaman.php" class="shortcut-card-link">
                <img src="assets/images/icon-pinjaman.svg" alt="Pinjam" class="shortcut-icon-img">
                <span>Pinjam</span>
            </a>

            <a href="cara-pinjam.php" class="shortcut-card-link">
                <img src="assets/images/icon-cara.svg" alt="Cara Pinjam" class="shortcut-icon-img">
                <span>Cara Pinjam</span>
            </a>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

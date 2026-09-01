<?php
$pageTitle = "Tagihan";
require_once __DIR__ . '/includes/header.php';
requireAuth();

$user = getLoggedInUser();
$pdo = getDbConnection();
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

// Ambil data tagihan belum bayar
$stmtUnpaid = $pdo->prepare("
    SELECT b.*, l.nominal as loan_nominal, l.tenor as loan_tenor 
    FROM bills b 
    JOIN loans l ON b.loan_id = l.id 
    WHERE b.user_id = ? AND b.status = 'belum_bayar' 
    ORDER BY b.jatuh_tempo ASC
");
$stmtUnpaid->execute([$user['id']]);
$unpaidBills = $stmtUnpaid->fetchAll();

// Ambil data tagihan sudah bayar
$stmtPaid = $pdo->prepare("
    SELECT b.*, l.nominal as loan_nominal, l.tenor as loan_tenor 
    FROM bills b 
    JOIN loans l ON b.loan_id = l.id 
    WHERE b.user_id = ? AND b.status = 'sudah_bayar' 
    ORDER BY b.tanggal_bayar DESC
");
$stmtPaid->execute([$user['id']]);
$paidBills = $stmtPaid->fetchAll();

// Hitung total pinjaman aktif yang belum lunas
$stmtTotal = $pdo->prepare("SELECT SUM(nominal_cicilan) as total_unpaid FROM bills WHERE user_id = ? AND status = 'belum_bayar'");
$stmtTotal->execute([$user['id']]);
$totalUnpaid = $stmtTotal->fetchColumn() ?: 0;
?>

<div class="dashboard-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="dashboard-content">
        <h1 class="page-title" style="margin-bottom: 2rem;">Tagihan</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- SUMMARY TOTAL PINJAMAN -->
        <div class="tagihan-summary-header">
            <span>Total Pinjaman</span>
            <h2>Rp<?= number_format($totalUnpaid, 0, ',', '.') ?></h2>
        </div>

        <!-- TABS FILTER -->
        <div class="tagihan-tabs">
            <button class="tagihan-tab-btn active" data-tab="tab-belum-bayar">Belum Bayar</button>
            <button class="tagihan-tab-btn" data-tab="tab-sudah-bayar">Sudah Bayar</button>
        </div>

        <!-- TAB CONTENT 1: BELUM BAYAR -->
        <div id="tab-belum-bayar" class="tagihan-tab-pane">
            <?php if (empty($unpaidBills)): ?>
                <!-- EMPTY STATE -->
                <div class="tagihan-empty-state">
                    <img src="assets/images/icon-empty-bill.svg" alt="Tidak Ada Tagihan" class="empty-state-img">
                    <h3>Tidak Ada Riwayat Peminjaman, Yuk Segera Ajukan Pinjaman</h3>
                    <div style="margin-top: 1.5rem;">
                        <a href="pinjaman.php" class="btn-hero-primary" style="display:inline-block; padding: 0.75rem 1.8rem;">Ajukan Pinjaman</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- DAFTAR TAGIHAN BELUM BAYAR -->
                <div class="bills-list">
                    <?php foreach ($unpaidBills as $bill): ?>
                        <div class="bill-card-item">
                            <div>
                                <div class="bill-info-title">Cicilan Bulan Ke-<?= $bill['bulan_ke'] ?> (Tenor <?= $bill['loan_tenor'] ?> Bln)</div>
                                <div class="bill-info-meta">
                                    Jatuh Tempo: <strong><?= date('d M Y', strtotime($bill['jatuh_tempo'])) ?></strong> &bull; Pokok Pinjaman: <?= formatRupiah($bill['loan_nominal']) ?>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <div class="bill-amount"><?= formatRupiah($bill['nominal_cicilan']) ?></div>
                                <button type="button" class="btn-pay-action" 
                                        onclick="openPaymentModal(<?= $bill['id'] ?>, <?= $bill['nominal_cicilan'] ?>, <?= $bill['bulan_ke'] ?>)">
                                    Bayar
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- TAB CONTENT 2: SUDAH BAYAR -->
        <div id="tab-sudah-bayar" class="tagihan-tab-pane" style="display: none;">
            <?php if (empty($paidBills)): ?>
                <div class="tagihan-empty-state">
                    <img src="assets/images/icon-empty-bill.svg" alt="Belum Ada Pembayaran" class="empty-state-img">
                    <h3>Belum Ada Riwayat Pembayaran</h3>
                </div>
            <?php else: ?>
                <div class="bills-list">
                    <?php foreach ($paidBills as $bill): ?>
                        <div class="bill-card-item" style="border-left: 5px solid #10b981;">
                            <div>
                                <div class="bill-info-title">Cicilan Bulan Ke-<?= $bill['bulan_ke'] ?> (Lunas)</div>
                                <div class="bill-info-meta">
                                    Dibayar Pada: <strong><?= date('d M Y H:i', strtotime($bill['tanggal_bayar'])) ?></strong>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div class="bill-amount" style="color: #10b981;"><?= formatRupiah($bill['nominal_cicilan']) ?></div>
                                <span style="background: #dcfce7; color: #15803d; font-size: 0.85rem; font-weight: 700; padding: 0.4rem 0.9rem; border-radius: 20px;">LUNAS</span>
                                <a href="cetak-bukti.php?id=<?= $bill['id'] ?>" target="_blank" 
                                   style="background: #0284c7; color: #ffffff; text-decoration: none; font-size: 0.85rem; font-weight: 600; padding: 0.45rem 0.9rem; border-radius: 8px; transition: background 0.2s;"
                                   title="Cetak Bukti Transaksi Resmi">
                                    🖨️ Resi PDF
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- MODAL PEMBAYARAN TAGIHAN -->
<div id="paymentModal" class="modal-backdrop">
    <div class="modal-box">
        <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">Konfirmasi Pembayaran</h3>
        <p style="color: #64748b; font-size: 0.92rem; margin-bottom: 1.5rem;">Pastikan nominal dan jadwal tagihan Anda sudah sesuai.</p>

        <form action="handlers/payment_handler.php" method="POST">
            <input type="hidden" name="bill_id" id="modalBillId" value="">

            <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #64748b;">Tagihan:</span>
                    <strong id="modalBulan" style="color: #0f172a;">-</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #64748b;">Total Bayar:</span>
                    <strong id="modalNominal" style="color: #0284c7; font-size: 1.2rem;">-</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b;">Metode:</span>
                    <span style="font-weight: 600; color: #0f172a;">Virtual Account / Saldo Otomatis</span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="button" class="btn-auth-submit" style="background: #cbd5e1; color: #1e293b;" onclick="closePaymentModal()">Batal</button>
                <button type="submit" class="btn-auth-submit" style="background: #10b981;">Konfirmasi Bayar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

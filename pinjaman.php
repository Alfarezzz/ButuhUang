<?php
$pageTitle = "Mengajukan Pinjaman";
require_once __DIR__ . '/includes/header.php';
requireAuth();

$user = getLoggedInUser();
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<div class="dashboard-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="dashboard-content">
        <h1 class="page-title">Mengajukan Pinjaman</h1>

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

        <div class="loan-form-box">
            <form action="handlers/loan_handler.php" method="POST">
                <!-- NAMA -->
                <div class="form-group">
                    <label style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Nama</label>
                    <input type="text" name="nama" class="loan-input-pill" placeholder="Masukkan Nama" required>
                </div>

                <!-- NIK -->
                <div class="form-group">
                    <label style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">NIK</label>
                    <input type="text" name="nik" class="loan-input-pill" placeholder="Masukkan NIK" required>
                </div>

                <!-- NOMINAL PINJAMAN SLIDER -->
                <div class="form-group" style="margin-top: 1rem;">
                    <div class="slider-group-header">
                        <span class="slider-label">Nominal Pinjaman</span>
                        <span class="slider-val-badge" id="nominalDisplay">1 Juta</span>
                    </div>
                    <input type="range" id="nominalSlider" name="nominal" class="custom-range-slider" 
                           min="500000" max="<?= min(20000000, max(500000, $user['limit_sisa'])) ?>" step="500000" value="1000000">
                </div>

                <!-- TENOR SLIDER -->
                <div class="form-group">
                    <div class="slider-group-header">
                        <span class="slider-label">Tenor</span>
                        <span class="slider-val-badge" id="tenorDisplay">3 Bulan</span>
                    </div>
                    <input type="range" id="tenorSlider" name="tenor" class="custom-range-slider" 
                           min="1" max="12" step="1" value="3">
                </div>

                <!-- RINCIAN SIMULASI -->
                <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 14px; padding: 1.2rem 1.5rem; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.95rem;">
                        <span style="color: #64748b;">Estimasi Angsuran:</span>
                        <strong id="cicilanDisplay" style="color: #0284c7; font-size: 1.05rem;">Rp 341.333 / bulan</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                        <span style="color: #64748b;">Total Pengembalian:</span>
                        <strong id="totalDisplay" style="color: #0f172a;">Rp 1.024.000</strong>
                    </div>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.6rem;">
                        * Suku bunga ringan kompetitif (0.8% per bulan). Tidak ada biaya tersembunyi.
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit" class="btn-ajukan-pinjaman">Ajukan Pinjaman</button>
            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

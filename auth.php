<?php
$pageTitle = "Masuk & Pendaftaran Akun";
require_once __DIR__ . '/includes/header.php';

$error = $_GET['error'] ?? '';
$msg = $_GET['msg'] ?? '';
?>

<div style="background-color: #f8fafc; padding: 2rem 0 5rem;">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="margin-top: 1rem;">
                <strong>Perhatian:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($msg)): ?>
            <div class="alert alert-success" style="margin-top: 1rem;">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="auth-container">
        <!-- FORM MASUK (LOGIN) -->
        <div class="auth-card">
            <h2 class="auth-title">Masuk</h2>
            <p class="auth-subtitle">Selamat datang. Silahkan masuk menggunakan akun ButuhUang anda</p>

            <form action="handlers/auth_handler.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="telepon_login">Nomor Telepon</label>
                    <input type="text" id="telepon_login" name="telepon" class="form-control" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="form-group">
                    <label for="sandi_login">Sandi</label>
                    <input type="password" id="sandi_login" name="sandi" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>

                <button type="submit" class="btn-auth-submit">Masuk</button>
            </form>

            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed #cbd5e1; font-size: 0.85rem; color: #64748b;">
                <strong>Akun Demo:</strong><br>
                Telepon: <code>081234567890</code> | Sandi: <code>password123</code>
            </div>
        </div>

        <!-- FORM DAFTAR (REGISTER) -->
        <div class="auth-card" style="border: 1.5px solid #e2e8f0;">
            <h2 class="auth-title" style="color:#0f172a;">Daftar</h2>
            <p class="auth-subtitle">Bergabung sebagai Peminjam. Angsuran dibayarkan secara bulanan dan terjangkau dengan memperhatikan profil dan kapasitas peminjam.</p>

            <form action="handlers/auth_handler.php" method="POST">
                <input type="hidden" name="action" value="register">
                
                <div class="form-group">
                    <label for="telepon_reg">Nomor Telepon</label>
                    <input type="text" id="telepon_reg" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="nama_reg">Nama Sesuai KTP</label>
                    <input type="text" id="nama_reg" name="nama" class="form-control" placeholder="Nama lengkap sesuai identitas" required>
                </div>

                <div class="form-group">
                    <label for="nik_reg">NIK / No Identitas</label>
                    <input type="text" id="nik_reg" name="nik" class="form-control" placeholder="16 digit nomor induk kependudukan" required>
                </div>

                <div class="form-group">
                    <label for="email_reg">Email</label>
                    <input type="email" id="email_reg" name="email" class="form-control" placeholder="alamat@email.com" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="sandi_reg">Sandi</label>
                        <input type="password" id="sandi_reg" name="sandi" class="form-control" placeholder="Buat kata sandi" required>
                    </div>

                    <div class="form-group">
                        <label for="sandi_ulang">Sandi (Ulangi)</label>
                        <input type="password" id="sandi_ulang" name="sandi_ulang" class="form-control" placeholder="Ulangi sandi" required>
                    </div>
                </div>

                <button type="submit" class="btn-auth-submit btn-daftar-submit">Daftar Sekarang</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

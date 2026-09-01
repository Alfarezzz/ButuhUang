<?php
$pageTitle = "Cara Pinjam";
require_once __DIR__ . '/includes/header.php';
?>

<div class="dashboard-layout">
    <?php if (getLoggedInUser()): ?>
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <?php endif; ?>

    <main class="dashboard-content" style="max-width: 950px;">
        <h1 class="page-title">Panduan & Cara Pinjam</h1>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 2.5rem; margin-bottom: 2rem;">
            <h2 style="font-size: 1.4rem; color: #0284c7; margin-bottom: 1.5rem;">4 Langkah Mudah Memperoleh Pinjaman</h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #38bdf8;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">1. Pendaftaran Akun</h3>
                    <p style="color: #64748b; font-size: 0.92rem;">
                        Buat akun dengan nomor telepon aktif, KTP, dan email valid. Verifikasi identitas Anda dilakukan secara instan.
                    </p>
                </div>

                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #0099ff;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">2. Tentukan Nominal & Tenor</h3>
                    <p style="color: #64748b; font-size: 0.92rem;">
                        Gunakan slider interaktif kami untuk memilih nominal pinjaman mulai dari Rp 500.000 hingga sisa limit Anda, serta tenor 1-12 bulan.
                    </p>
                </div>

                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #10b981;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">3. Persetujuan Cepat</h3>
                    <p style="color: #64748b; font-size: 0.92rem;">
                        Sistem scoring kredit kami memproses persetujuan pengajuan dalam hitungan detik tanpa dokumen fisik berbelit.
                    </p>
                </div>

                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #f59e0b;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">4. Pembayaran Mudah</h3>
                    <p style="color: #64748b; font-size: 0.92rem;">
                        Pantau seluruh jadwal cicilan di menu Tagihan. Setiap cicilan yang dibayar akan langsung memulihkan limit pinjaman Anda.
                    </p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="pinjaman.php" class="btn-hero-primary" style="padding: 0.85rem 2.2rem;">Ajukan Pinjaman Sekarang</a>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

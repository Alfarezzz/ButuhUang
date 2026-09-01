<?php
$pageTitle = "Pusat Bantuan & FAQ";
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: #f8fafc; padding: 4rem 1.5rem 6rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <!-- HEADER -->
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <h1 class="page-title" style="margin-bottom: 0.8rem;">Pusat Bantuan & FAQ</h1>
            <p style="color: #64748b; font-size: 1.05rem;">
                Temukan jawaban cepat seputar syarat pengajuan, batas limit, suku bunga, dan keamanan data di ButuhUang.
            </p>
        </div>

        <!-- FAQ ACCORDION CONTAINER -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <!-- FAQ ITEM 1 -->
            <div class="faq-card" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                <button class="faq-header-btn" style="width: 100%; text-align: left; padding: 1.3rem 1.5rem; background: none; border: none; font-size: 1.05rem; font-weight: 700; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>1. Apa saja persyaratan untuk mengajukan pinjaman di ButuhUang?</span>
                    <span class="faq-icon" style="font-size: 1.3rem; color: #0284c7; transition: transform 0.2s;">+</span>
                </button>
                <div class="faq-body" style="padding: 0 1.5rem 1.3rem; color: #64748b; font-size: 0.95rem; line-height: 1.7; display: none;">
                    Persyaratannya sangat mudah! Anda hanya perlu:
                    <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                        <li>Warga Negara Indonesia (WNI) berusia minimal 18 tahun.</li>
                        <li>Memiliki Kartu Tanda Penduduk (e-KTP) yang sah dan masih berlaku.</li>
                        <li>Memiliki nomor telepon aktif dan rekening bank atas nama pribadi.</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ ITEM 2 -->
            <div class="faq-card" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                <button class="faq-header-btn" style="width: 100%; text-align: left; padding: 1.3rem 1.5rem; background: none; border: none; font-size: 1.05rem; font-weight: 700; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>2. Berapa batas limit pinjaman awal yang diberikan?</span>
                    <span class="faq-icon" style="font-size: 1.3rem; color: #0284c7; transition: transform 0.2s;">+</span>
                </button>
                <div class="faq-body" style="padding: 0 1.5rem 1.3rem; color: #64748b; font-size: 0.95rem; line-height: 1.7; display: none;">
                    Setiap pengguna baru yang terdaftar dan terverifikasi secara otomatis mendapatkan plafon limit pinjaman awal hingga <strong>Rp 69.696.666</strong>. Plafon limit ini dapat dicairkan bertahap sesuai kebutuhan mulai dari Rp 500.000.
                </div>
            </div>

            <!-- FAQ ITEM 3 -->
            <div class="faq-card" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                <button class="faq-header-btn" style="width: 100%; text-align: left; padding: 1.3rem 1.5rem; background: none; border: none; font-size: 1.05rem; font-weight: 700; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>3. Bagaimana skema perhitungan suku bunga dan biaya?</span>
                    <span class="faq-icon" style="font-size: 1.3rem; color: #0284c7; transition: transform 0.2s;">+</span>
                </button>
                <div class="faq-body" style="padding: 0 1.5rem 1.3rem; color: #64748b; font-size: 0.95rem; line-height: 1.7; display: none;">
                    Kami menerapkan prinsip transparansi tanpa biaya tersembunyi. Suku bunga pinjaman adalah <strong>flat 0.8% per bulan</strong> (maksimal di bawah 10% per tahun). Anda dapat melihat rincian cicilan per bulan secara transparan di kalkulator simulasi sebelum mengajukan.
                </div>
            </div>

            <!-- FAQ ITEM 4 -->
            <div class="faq-card" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                <button class="faq-header-btn" style="width: 100%; text-align: left; padding: 1.3rem 1.5rem; background: none; border: none; font-size: 1.05rem; font-weight: 700; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>4. Apakah data pribadi dan privasi saya aman?</span>
                    <span class="faq-icon" style="font-size: 1.3rem; color: #0284c7; transition: transform 0.2s;">+</span>
                </button>
                <div class="faq-body" style="padding: 0 1.5rem 1.3rem; color: #64748b; font-size: 0.95rem; line-height: 1.7; display: none;">
                    Sangat aman. Seluruh data pengguna dienkripsi dengan standar enkripsi modern (Bcrypt & SSL/TLS). Kami tidak membagikan atau menjual data pribadi nasabah kepada pihak ketiga manapun tanpa izin Anda.
                </div>
            </div>

            <!-- FAQ ITEM 5 -->
            <div class="faq-card" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                <button class="faq-header-btn" style="width: 100%; text-align: left; padding: 1.3rem 1.5rem; background: none; border: none; font-size: 1.05rem; font-weight: 700; color: #0f172a; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>5. Bagaimana cara membayar cicilan tagihan bulanan?</span>
                    <span class="faq-icon" style="font-size: 1.3rem; color: #0284c7; transition: transform 0.2s;">+</span>
                </button>
                <div class="faq-body" style="padding: 0 1.5rem 1.3rem; color: #64748b; font-size: 0.95rem; line-height: 1.7; display: none;">
                    Masuk ke akun Anda, buka menu <strong>Tagihan</strong>, lalu klik tombol <strong>Bayar</strong> pada tagihan bulan berjalan. Anda dapat membayar melalui transfer Virtual Account bank atau dompet digital. Setiap kali tagihan lunas, sisa limit pinjaman Anda akan bertambah kembali secara otomatis!
                </div>
            </div>
        </div>

        <!-- HELP DESK CONTACT CARD -->
        <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; border-radius: 20px; padding: 2.5rem; margin-top: 3.5rem; display: flex; justify-content: space-between; align-items: center; gap: 2rem;">
            <div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 0.5rem;">Masih memiliki pertanyaan?</h3>
                <p style="color: #cbd5e1; font-size: 0.95rem;">Tim Customer Support kami siap membantu Anda 24 jam setiap hari.</p>
            </div>
            <a href="mailto:smkcikini@ymail.com" class="btn-nav-auth" style="padding: 0.8rem 1.8rem; font-size: 0.95rem; text-decoration: none; white-space: nowrap;">
                Hubungi Support
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const faqButtons = document.querySelectorAll('.faq-header-btn');
    faqButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const body = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isOpen = body.style.display === 'block';

            // Close all
            document.querySelectorAll('.faq-body').forEach(b => b.style.display = 'none');
            document.querySelectorAll('.faq-icon').forEach(i => {
                i.textContent = '+';
                i.style.transform = 'rotate(0deg)';
            });

            if (!isOpen) {
                body.style.display = 'block';
                icon.textContent = '−';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

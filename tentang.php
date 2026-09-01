<?php
$pageTitle = "Tentang Kami";
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: #ffffff; padding: 4rem 1.5rem 6rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 class="page-title" style="margin-bottom: 1rem;">Tentang ButuhUang</h1>
        <p style="text-align: center; color: #64748b; font-size: 1.1rem; margin-bottom: 3.5rem;">
            Platform Financial Technology (Fintech) P2P Lending Berbasis Web Modern.
        </p>

        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2.5rem; margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; color: #0284c7; margin-bottom: 1rem;">Visi & Misi Platform</h2>
            <p style="color: #475569; line-height: 1.8; margin-bottom: 1rem;">
                <strong>ButuhUang</strong> didirikan dengan tujuan memberi layanan finansial yang inklusif, cepat, transparan, dan bertanggung jawab. Kami menghubungkan kebutuhan likuiditas jangka pendek dengan sistem manajemen risiko terukur.
            </p>
            <p style="color: #475569; line-height: 1.8;">
                Melalui antarmuka yang ramah pengguna, nasabah dapat mengatur perencanaan finansial secara mandiri mulai dari kalkulasi simulasi pinjaman, pemantauan limit, hingga pelunasan tagihan real-time.
            </p>
        </div>

        <div style="background: #e0f2fe; border: 1.5px solid #bae6fd; border-radius: 18px; padding: 2.5rem;">
            <h2 style="font-size: 1.35rem; color: #0369a1; margin-bottom: 1rem;">Latar Belakang Proyek Portofolio</h2>
            <p style="color: #0c4a6e; line-height: 1.8; margin-bottom: 1rem;">
                Aplikasi ini merupakan hasil evolusi komprehensif dari proyek tugas akhir jenjang SMK yang di-refactor dan dikembangkan lebih lanjut menjadi platform web full-stack modern berstandar industri untuk portofolio mahasiswa Teknik Informatika.
            </p>
            <ul style="color: #0c4a6e; margin-left: 1.5rem; line-height: 1.8;">
                <li><strong>Backend:</strong> PHP 8+, PDO Database Layer, Dual Database Engine (Zero-config SQLite & MySQL).</li>
                <li><strong>Security:</strong> Password Hashing (Bcrypt), SQL Injection Prevention via Prepared Statements, Session Protection.</li>
                <li><strong>Frontend:</strong> Responsive UI/UX, Dynamic SVG Assets, Real-Time Loan Calculators, Modal Interactivity.</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/config/database.php';
requireAuth();

$user = getLoggedInUser();
$pdo = getDbConnection();
$billId = intval($_GET['id'] ?? 0);

if ($billId <= 0) {
    die("ID Tagihan tidak valid.");
}

// Ambil data tagihan lunas
$stmt = $pdo->prepare("
    SELECT b.*, l.nominal as loan_nominal, l.tenor as loan_tenor, l.bunga_persen, l.created_at as loan_created
    FROM bills b 
    JOIN loans l ON b.loan_id = l.id 
    WHERE b.id = ? AND b.user_id = ? AND b.status = 'sudah_bayar'
");
$stmt->execute([$billId, $user['id']]);
$bill = $stmt->fetch();

if (!$bill) {
    die("Bukti pembayaran tidak ditemukan atau tagihan belum berstatus lunas.");
}

$noReferensi = 'PAY-' . date('Ymd', strtotime($bill['tanggal_bayar'])) . '-' . str_pad($bill['id'], 5, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - <?= htmlspecialchars($noReferensi) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #f1f5f9;
            padding: 2rem 1rem;
            color: #0f172a;
        }
        .receipt-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .receipt-watermark {
            position: absolute;
            right: -20px;
            bottom: -20px;
            opacity: 0.04;
            pointer-events: none;
            width: 280px;
        }
        .stamp-lunas {
            position: absolute;
            right: 40px;
            top: 40px;
            border: 3px dashed #10b981;
            color: #10b981;
            padding: 6px 18px;
            font-size: 1.1rem;
            font-weight: 900;
            letter-spacing: 2px;
            border-radius: 8px;
            transform: rotate(-10deg);
            user-select: none;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.95rem;
        }
        .receipt-row:last-child {
            border-bottom: none;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                padding: 1.5rem 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <img src="assets/images/logo.png" alt="Watermark" class="receipt-watermark">
    <div class="stamp-lunas">LUNAS</div>

    <!-- HEADER RESI -->
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 2rem;">
        <img src="assets/images/logo.png" alt="ButuhUang" style="height: 48px; width: auto; object-fit: contain;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.1;">Butuh<span style="color:#0099ff;">Uang</span></h2>
            <span style="font-size: 0.8rem; color: #64748b; font-weight: 500;">PT Pengangguran Sejati &bull; Bukti Transaksi Resmi</span>
        </div>
    </div>

    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.8rem; text-align: center; border: 1px solid #e2e8f0;">
        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Pembayaran Angsuran</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #10b981; margin: 0.2rem 0;"><?= formatRupiah($bill['nominal_cicilan']) ?></div>
        <div style="font-size: 0.82rem; color: #64748b;">No. Referensi: <strong><?= htmlspecialchars($noReferensi) ?></strong></div>
    </div>

    <!-- RINCIAN TRANSAKSI -->
    <div style="margin-bottom: 2rem;">
        <div class="receipt-row">
            <span style="color: #64748b;">Nama Peminjam</span>
            <strong><?= htmlspecialchars($user['nama']) ?></strong>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">NIK</span>
            <strong><?= htmlspecialchars($user['nik']) ?></strong>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">Nomor Telepon</span>
            <strong><?= htmlspecialchars($user['telepon']) ?></strong>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">Keterangan Pembayaran</span>
            <strong>Cicilan Bulan ke-<?= $bill['bulan_ke'] ?> (Tenor <?= $bill['loan_tenor'] ?> Bln)</strong>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">Pokok Pinjaman Total</span>
            <span><?= formatRupiah($bill['loan_nominal']) ?></span>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">Tanggal & Waktu Bayar</span>
            <strong><?= date('d F Y, H:i:s', strtotime($bill['tanggal_bayar'])) ?> WIB</strong>
        </div>
        <div class="receipt-row">
            <span style="color: #64748b;">Metode Pelunasan</span>
            <span style="font-weight: 600; color: #0284c7;">Auto-Debit / Virtual Account</span>
        </div>
    </div>

    <!-- FOOTER RESI -->
    <div style="border-top: 1.5px solid #e2e8f0; padding-top: 1.2rem; font-size: 0.78rem; color: #94a3b8; line-height: 1.6; text-align: center;">
        * Dokumen ini merupakan bukti pembayaran elektronik yang sah dan diterbitkan secara otomatis oleh sistem ButuhUang Fintech Platform.
    </div>

    <!-- TOMBOL AKSI CETAK -->
    <div class="no-print" style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center;">
        <a href="tagihan.php" class="btn-auth-submit" style="background: #cbd5e1; color: #1e293b; text-decoration: none; padding: 0.75rem 1.6rem; display: inline-block; text-align: center;">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="btn-hero-primary" style="padding: 0.75rem 2rem; border: none; cursor: pointer;">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>
</div>

</body>
</html>

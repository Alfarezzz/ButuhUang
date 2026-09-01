<?php
require_once __DIR__ . '/../config/database.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getLoggedInUser();
    $pdo = getDbConnection();

    $nominal = floatval($_POST['nominal'] ?? 0);
    $tenor = intval($_POST['tenor'] ?? 0);

    if ($nominal < 500000 || $nominal > 50000000) {
        header("Location: ../pinjaman.php?error=" . urlencode("Nominal pinjaman di luar batas yang diizinkan (Rp 500.000 - Rp 50.000.000)"));
        exit;
    }

    if ($tenor < 1 || $tenor > 12) {
        header("Location: ../pinjaman.php?error=" . urlencode("Tenor harus antara 1 sampai 12 bulan"));
        exit;
    }

    if ($nominal > $user['limit_sisa']) {
        header("Location: ../pinjaman.php?error=" . urlencode("Nominal pinjaman melebihi sisa limit Anda saat ini (" . formatRupiah($user['limit_sisa']) . ")"));
        exit;
    }

    $bungaPersen = 0.8; // 0.8% per bulan (Bunga maks 10% per tahun)
    $totalBunga = $nominal * (($bungaPersen / 100) * $tenor);
    $totalPinjaman = $nominal + $totalBunga;
    $cicilanPerBulan = $totalPinjaman / $tenor;

    $pdo->beginTransaction();
    try {
        // 1. Simpan Pinjaman
        $stmtLoan = $pdo->prepare("INSERT INTO loans (user_id, nominal, tenor, bunga_persen, total_pinjaman, cicilan_per_bulan, status) VALUES (?, ?, ?, ?, ?, ?, 'disetujui')");
        $stmtLoan->execute([$user['id'], $nominal, $tenor, $bungaPersen, $totalPinjaman, $cicilanPerBulan]);
        $loanId = $pdo->lastInsertId();

        // 2. Generate Tagihan per Bulan
        $stmtBill = $pdo->prepare("INSERT INTO bills (loan_id, user_id, bulan_ke, nominal_cicilan, jatuh_tempo, status) VALUES (?, ?, ?, ?, ?, 'belum_bayar')");
        
        for ($i = 1; $i <= $tenor; $i++) {
            $jatuhTempo = date('Y-m-d', strtotime("+$i month"));
            $stmtBill->execute([$loanId, $user['id'], $i, $cicilanPerBulan, $jatuhTempo]);
        }

        // 3. Potong Limit Sisa Pengguna
        $newLimit = $user['limit_sisa'] - $nominal;
        $stmtUser = $pdo->prepare("UPDATE users SET limit_sisa = ? WHERE id = ?");
        $stmtUser->execute([$newLimit, $user['id']]);

        $pdo->commit();

        header("Location: ../tagihan.php?success=" . urlencode("Pengajuan pinjaman sebesar " . formatRupiah($nominal) . " berhasil disetujui! Dana segera ditransfer ke rekening Anda."));
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: ../pinjaman.php?error=" . urlencode("Gagal memproses pinjaman: " . $e->getMessage()));
        exit;
    }
}

header("Location: ../pinjaman.php");
exit;

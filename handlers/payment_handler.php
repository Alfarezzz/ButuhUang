<?php
require_once __DIR__ . '/../config/database.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getLoggedInUser();
    $pdo = getDbConnection();
    $billId = intval($_POST['bill_id'] ?? 0);

    if ($billId <= 0) {
        header("Location: ../tagihan.php?error=" . urlencode("ID Tagihan tidak valid"));
        exit;
    }

    // Ambil data tagihan & pinjaman terkait
    $stmt = $pdo->prepare("
        SELECT b.*, l.nominal as loan_nominal, l.tenor as loan_tenor 
        FROM bills b 
        JOIN loans l ON b.loan_id = l.id 
        WHERE b.id = ? AND b.user_id = ? AND b.status = 'belum_bayar'
    ");
    $stmt->execute([$billId, $user['id']]);
    $bill = $stmt->fetch();

    if (!$bill) {
        header("Location: ../tagihan.php?error=" . urlencode("Tagihan tidak ditemukan atau sudah dibayar"));
        exit;
    }

    $pdo->beginTransaction();
    try {
        // 1. Update status tagihan
        $updateBill = $pdo->prepare("UPDATE bills SET status = 'sudah_bayar', tanggal_bayar = datetime('now', 'localtime') WHERE id = ?");
        $updateBill->execute([$billId]);

        // 2. Kembalikan limit pinjaman pokok (pokok per bulan)
        $pokokDikembalikan = $bill['loan_nominal'] / $bill['loan_tenor'];
        $newLimit = min($user['limit_total'], $user['limit_sisa'] + $pokokDikembalikan);

        $updateUser = $pdo->prepare("UPDATE users SET limit_sisa = ? WHERE id = ?");
        $updateUser->execute([$newLimit, $user['id']]);

        // 3. Cek apakah seluruh tagihan pinjaman ini telah lunas
        $checkRemaining = $pdo->prepare("SELECT COUNT(*) FROM bills WHERE loan_id = ? AND status = 'belum_bayar'");
        $checkRemaining->execute([$bill['loan_id']]);
        if ($checkRemaining->fetchColumn() == 0) {
            $updateLoan = $pdo->prepare("UPDATE loans SET status = 'lunas' WHERE id = ?");
            $updateLoan->execute([$bill['loan_id']]);
        }

        $pdo->commit();
        header("Location: ../tagihan.php?success=" . urlencode("Pembayaran tagihan bulan ke-" . $bill['bulan_ke'] . " berhasil diproses. Limit pinjaman Anda bertambah kembali!"));
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: ../tagihan.php?error=" . urlencode("Gagal memproses pembayaran: " . $e->getMessage()));
        exit;
    }
}

header("Location: ../tagihan.php");
exit;

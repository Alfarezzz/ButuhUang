<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $pdo = getDbConnection();

    if ($action === 'login') {
        $telepon = trim($_POST['telepon'] ?? '');
        $sandi = trim($_POST['sandi'] ?? '');

        if (empty($telepon) || empty($sandi)) {
            header("Location: ../auth.php?error=" . urlencode("Nomor telepon dan sandi harus diisi"));
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE telepon = ?");
        $stmt->execute([$telepon]);
        $user = $stmt->fetch();

        // Validasi password: Cek Bcrypt hash atau plain text fallback untuk fleksibilitas migrasi
        $passwordMatches = false;
        if ($user) {
            if (password_verify($sandi, $user['sandi']) || $sandi === $user['sandi']) {
                $passwordMatches = true;
                // Re-hash jika sebelumnya masih plain text
                if ($sandi === $user['sandi']) {
                    $newHash = password_hash($sandi, PASSWORD_BCRYPT);
                    $up = $pdo->prepare("UPDATE users SET sandi = ? WHERE id = ?");
                    $up->execute([$newHash, $user['id']]);
                }
            }
        }

        if ($user && $passwordMatches) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            header("Location: ../pinjaman.php?success=" . urlencode("Selamat datang kembali, " . $user['nama']));
            exit;
        } else {
            header("Location: ../auth.php?error=" . urlencode("Nomor telepon atau sandi salah"));
            exit;
        }
    } 
    elseif ($action === 'register') {
        $telepon = trim($_POST['telepon'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $nik = trim($_POST['nik'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $sandi = trim($_POST['sandi'] ?? '');
        $sandi_ulang = trim($_POST['sandi_ulang'] ?? '');

        if (empty($telepon) || empty($nama) || empty($nik) || empty($email) || empty($sandi)) {
            header("Location: ../auth.php?error=" . urlencode("Semua field pendaftaran wajib diisi"));
            exit;
        }

        if ($sandi !== $sandi_ulang) {
            header("Location: ../auth.php?error=" . urlencode("Konfirmasi sandi tidak sesuai"));
            exit;
        }

        // Cek apakah NIK atau Telepon sudah terdaftar
        $stmt = $pdo->prepare("SELECT id FROM users WHERE nik = ? OR telepon = ?");
        $stmt->execute([$nik, $telepon]);
        if ($stmt->fetch()) {
            header("Location: ../auth.php?error=" . urlencode("NIK atau Nomor Telepon sudah terdaftar di sistem"));
            exit;
        }

        // Insert User Baru dengan limit awal Rp 69.696.666
        $hash = password_hash($sandi, PASSWORD_BCRYPT);
        $insert = $pdo->prepare("INSERT INTO users (nama, nik, telepon, email, sandi, limit_total, limit_sisa) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$nama, $nik, $telepon, $email, $hash, 69696666.00, 69696666.00]);

        $userId = $pdo->lastInsertId();
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_nama'] = $nama;

        header("Location: ../pinjaman.php?success=" . urlencode("Pendaftaran berhasil! Akun Anda siap digunakan."));
        exit;
    }
}

header("Location: ../auth.php");
exit;

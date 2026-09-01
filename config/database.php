<?php
/**
 * ButuhUang - Database & Session Configuration
 * Mendukung SQLite3 / PDO SQLite (Zero Config) dan MySQL (XAMPP/Laragon)
 */

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

define('DB_DRIVER', 'sqlite'); // 'sqlite' atau 'mysql'
define('DB_HOST', 'localhost');
define('DB_NAME', 'butuhuang_db');
define('DB_USER', 'root');
define('DB_PASS', '');

class SQLiteWrapper {
    private $db;

    public function __construct($path) {
        $this->db = new SQLite3($path);
        $this->db->enableExceptions(true);
    }

    public function exec($sql) {
        return $this->db->exec($sql);
    }

    public function prepare($sql) {
        return new SQLiteStatementWrapper($this->db, $sql);
    }

    public function lastInsertId() {
        return $this->db->lastInsertRowID();
    }

    public function beginTransaction() {
        return $this->db->exec('BEGIN TRANSACTION');
    }

    public function commit() {
        return $this->db->exec('COMMIT');
    }

    public function rollBack() {
        return $this->db->exec('ROLLBACK');
    }
}

class SQLiteStatementWrapper {
    private $db;
    private $sql;
    private $stmt;
    private $lastResult;

    public function __construct($db, $sql) {
        $this->db = $db;
        $this->sql = $sql;
    }

    public function execute($params = []) {
        // Ganti tanda ? dengan parameter terikat jika ada
        $sql = $this->sql;
        if (!empty($params)) {
            $stmt = $this->db->prepare($sql);
            if ($stmt) {
                $idx = 1;
                foreach ($params as $param) {
                    $type = is_int($param) ? SQLITE3_INTEGER : (is_float($param) ? SQLITE3_FLOAT : (is_null($param) ? SQLITE3_NULL : SQLITE3_TEXT));
                    $stmt->bindValue($idx, $param, $type);
                    $idx++;
                }
                $this->lastResult = $stmt->execute();
                return true;
            }
        }
        $this->lastResult = $this->db->query($sql);
        return true;
    }

    public function fetch() {
        if ($this->lastResult) {
            $row = $this->lastResult->fetchArray(SQLITE3_ASSOC);
            return $row !== false ? $row : null;
        }
        return null;
    }

    public function fetchAll() {
        $rows = [];
        if ($this->lastResult) {
            while ($row = $this->lastResult->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function fetchColumn() {
        if ($this->lastResult) {
            $row = $this->lastResult->fetchArray(SQLITE3_NUM);
            return ($row !== false && isset($row[0])) ? $row[0] : false;
        }
        return false;
    }
}

function getDbConnection() {
    static $db = null;
    if ($db !== null) {
        return $db;
    }

    try {
        if (DB_DRIVER === 'sqlite') {
            $dbPath = __DIR__ . '/../database/butuhuang.sqlite';
            $dbDir = dirname($dbPath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            
            $isNew = !file_exists($dbPath);
            
            // Cek apakah ekstensi pdo_sqlite tersedia, jika tidak gunakan SQLite3 built-in
            if (extension_loaded('pdo_sqlite')) {
                $pdo = new PDO("sqlite:" . $dbPath);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $db = $pdo;
            } else {
                $db = new SQLiteWrapper($dbPath);
            }

            if ($isNew) {
                initDatabase($db);
            }
        } else {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db = $pdo;
        }
        return $db;
    } catch (Exception $e) {
        die("Koneksi Database Gagal: " . $e->getMessage());
    }
}

function initDatabase($db) {
    $schema = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama VARCHAR(150) NOT NULL,
        nik VARCHAR(20) UNIQUE NOT NULL,
        telepon VARCHAR(20) UNIQUE NOT NULL,
        email VARCHAR(100) NOT NULL,
        sandi VARCHAR(255) NOT NULL,
        limit_total DECIMAL(15,2) DEFAULT 69696666.00,
        limit_sisa DECIMAL(15,2) DEFAULT 69696666.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS loans (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        nominal DECIMAL(15,2) NOT NULL,
        tenor INTEGER NOT NULL,
        bunga_persen DECIMAL(5,2) NOT NULL,
        total_pinjaman DECIMAL(15,2) NOT NULL,
        cicilan_per_bulan DECIMAL(15,2) NOT NULL,
        status VARCHAR(30) DEFAULT 'disetujui',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id)
    );

    CREATE TABLE IF NOT EXISTS bills (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        loan_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        bulan_ke INTEGER NOT NULL,
        nominal_cicilan DECIMAL(15,2) NOT NULL,
        jatuh_tempo DATE NOT NULL,
        status VARCHAR(20) DEFAULT 'belum_bayar',
        tanggal_bayar DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (loan_id) REFERENCES loans (id),
        FOREIGN KEY (user_id) REFERENCES users (id)
    );
    ";
    
    $db->exec($schema);

    // Tambah akun demo default
    $demoCheck = $db->prepare("SELECT COUNT(*) FROM users WHERE telepon = ?");
    $demoCheck->execute(['081234567890']);
    if ($demoCheck->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (nama, nik, telepon, email, sandi, limit_total, limit_sisa) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            'Kelana Mahasiswa',
            '3172010101990001',
            '081234567890',
            'kelana@butuhuang.id',
            password_hash('password123', PASSWORD_BCRYPT),
            69696666.00,
            69696666.00
        ]);
    }
}

function getLoggedInUser() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $db = getDbConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: auth.php?msg=" . urlencode("Silakan masuk terlebih dahulu"));
        exit;
    }
}

function formatRupiah($angka) {
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}

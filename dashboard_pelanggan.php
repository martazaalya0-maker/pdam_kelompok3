<?php
session_start();
// Pastikan hanya pelanggan yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: views/auth/login.php");
    exit;
}

require_once 'config/database.php';
$id_user = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelanggan - PDAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7f6; }
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .main-content { margin-left: 260px; padding: 25px; }
        .card-stat { border-radius: 15px; border: none; padding: 20px; color: white; }
    </style>
</head>
<body>

<div class="sidebar p-3">
    <h5 class="text-center py-3">PDAM TIRTA JAYA</h5>
    <a href="dashboard_pelanggan.php" class="text-white text-decoration-none d-block p-2"><i class="bi bi-house"></i> Home</a>
    <a href="views/layout/tagihan_saya.php" class="text-white text-decoration-none d-block p-2"><i class="bi bi-receipt"></i> Tagihan Saya</a>
    <hr>
    <a href="views/auth/logout.php" class="text-white text-decoration-none d-block p-2"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
    <p>Berikut adalah ringkasan informasi tagihan Anda.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-stat bg-primary">
                <h5>Tagihan Terakhir</h5>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM tagihan WHERE id_pelanggan = '$id_user' ORDER BY id_tagihan DESC LIMIT 1");
                $data = mysqli_fetch_assoc($query);
                if ($data) {
                    echo "<h2>Rp " . number_format($data['total_tagihan'], 0, ',', '.') . "</h2>";
                    echo "<span>Status: <b>" . $data['status_bayar'] . "</b></span>";
                } else {
                    echo "<h2>Rp 0</h2><span>Tidak ada tagihan terbaru.</span>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
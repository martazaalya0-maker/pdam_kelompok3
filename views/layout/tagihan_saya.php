<?php
session_start();
// Pastikan hanya pelanggan yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: views/auth/login.php");
    exit;
}

// Tambahkan ../ untuk keluar dari folder layout, lalu keluar lagi dari folder views
require_once '../../config/database.php';
$id_pelanggan = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tagihan Saya - PDAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7f6; }
        .main-content { padding: 40px; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-receipt"></i> Daftar Tagihan Saya</h3>
        <a href="../../dashboard_pelanggan.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card shadow-sm p-4">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID Tagihan</th>
                    <th>Total m3</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data tagihan milik pelanggan yang sedang login saja
                $query = "SELECT * FROM tagihan WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_tagihan DESC";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $is_lunas = ($row['status_bayar'] == 'Lunas');
                        $status_badge = $is_lunas ? "bg-success" : "bg-danger";
                        
                        echo "<tr>
                            <td>{$row['id_tagihan']}</td>
                            <td>{$row['total_m3']} m3</td>
                            <td>Rp " . number_format($row['total_tagihan'], 0, ',', '.') . "</td>
                            <td><span class='badge $status_badge'>{$row['status_bayar']}</span></td>
                            <td>";
                            
                            if (!$is_lunas) {
                                echo "<a href='controllers/ProsesBayarPelanggan.php?id={$row['id_tagihan']}' 
                                      class='btn btn-sm btn-primary' 
                                      onclick='return confirm(\"Apakah Anda yakin ingin membayar tagihan ini secara online?\")'>
                                      <i class='bi bi-credit-card'></i> Bayar Online
                                      </a>";
                            } else {
                                echo "<span class='text-muted'><i class='bi bi-check-circle'></i> Selesai</span>";
                            }
                            
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Belum ada tagihan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
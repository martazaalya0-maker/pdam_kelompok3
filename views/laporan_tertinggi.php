<?php
session_start();
require_once '../config/database.php';

// 1. Pengaturan Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// 2. Query Data
$query = mysqli_query($conn, "SELECT t.*, pl.nama_pelanggan 
                             FROM tagihan t 
                             JOIN pelanggan pl ON t.id_pelanggan = pl.id_pelanggan 
                             ORDER BY t.total_m3 DESC 
                             LIMIT $limit OFFSET $offset");

$total_data_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tagihan");
$total_data = mysqli_fetch_assoc($total_data_query)['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tertinggi - PDAM Tirta Jaya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px 20px; transition: 0.3s; }
        .sidebar a:hover { background-color: #006666; }
        .main-content { margin-left: 260px; padding: 20px; }
        .sidebar a.active { background-color: #006666; font-weight: bold; }
        @media print { .sidebar, .btn-print, .pagination { display: none !important; } .main-content { margin-left: 0 !important; } }
    </style>
</head>
<body class="bg-light">

<div class="sidebar">
    <div class="p-3"><h5>PDAM TIRTA JAYA MANDIRI</h5></div>
    <hr>
    <a href="../dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="input_data_pelanggan.php"><i class="bi bi-people"></i> Input Data Pelanggan</a>
    <a href="input_meter_air.php"><i class="bi bi-speedometer"></i> Input Meter Air</a>
    <a href="../tagihan.php"><i class="bi bi-receipt"></i> Searching Tagihan</a>
    <a href="input_data_per_periode.php"><i class="bi bi-calendar-check"></i> Laporan Per Periode</a>
    <a href="input_data_per_tahun.php"><i class="bi bi-calendar-event"></i> Laporan Per Tahun</a>
    <a href="laporan_tertinggi.php" class="active"><i class="bi bi-graph-up-arrow"></i> Laporan Tertinggi</a>
    <hr>
    <a href="views/auth/logout.php" class="text-white"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Laporan Penggunaan Air Tertinggi</h4>
        <button onclick="window.print()" class="btn btn-secondary btn-print"><i class="bi bi-printer"></i> Cetak</button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="text-white" style="background-color: #008b8b;">
                    <tr>
                        <th>Peringkat</th><th>Nama Pelanggan</th><th>Volume (m³)</th><th>Total Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = $offset + 1;
                    while ($data = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="fw-bold text-danger">#<?= $no++; ?></td>
                        <td><?= $data['nama_pelanggan']; ?></td>
                        <td><?= $data['total_m3']; ?> m³</td>
                        <td>Rp <?= number_format($data['total_tagihan'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a>
                    </li>
                    <?php for($i=1; $i<=$total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</body>
</html>
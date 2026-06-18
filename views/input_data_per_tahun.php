<?php
session_start();
require_once '../config/database.php'; // Sesuaikan path ini
$tahun_pilihan = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Per Tahun - PDAM Tirta Jaya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px 20px; transition: 0.3s; }
        .sidebar a:hover { background-color: #006666; }
        .main-content { margin-left: 260px; padding: 20px; }
        .sidebar a.active { background-color: #006666; font-weight: bold; }
        @media print { .sidebar, .filter-card, .btn-print { display: none !important; } .main-content { margin-left: 0 !important; } }
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
    <a href="auth/logout.php" class="text-white"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <h4>Laporan Per Tahun</h4>
    <div class="card mb-4 filter-card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-10">
                    <label class="form-label small fw-bold text-muted">Pilih Tahun</label>
                    <select name="tahun" class="form-select">
                        <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                            <option value="<?= $i; ?>" <?= $i == $tahun_pilihan ? 'selected' : ''; ?>><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn text-white w-100" style="background-color: #008b8b;"><i class="bi bi-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <button onclick="window.print()" class="btn btn-secondary btn-print mb-3"><i class="bi bi-printer"></i> Cetak Laporan</button>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #008b8b;">
                        <tr>
                            <th>No</th><th>Nama</th><th>Bulan</th><th>Volume</th><th>Total Tagihan</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = mysqli_query($conn, "SELECT p.*, pl.nama_pelanggan, t.total_m3, t.total_tagihan, t.status_bayar 
                                                     FROM pemakaian p 
                                                     JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                                     LEFT JOIN tagihan t ON p.id_pelanggan = t.id_pelanggan 
                                                     WHERE YEAR(p.tanggal_catat) = '$tahun_pilihan' 
                                                     ORDER BY p.tanggal_catat ASC");
                        
                        if (mysqli_num_rows($query) > 0):
                            $no = 1;
                            while ($data = mysqli_fetch_assoc($query)): 
                                $status = !empty($data['status_bayar']) ? $data['status_bayar'] : 'Belum Bayar';
                                $warna = ($status == 'Lunas') ? 'text-success' : 'text-danger';
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nama_pelanggan']; ?></td>
                            <td><?= date('F', strtotime($data['tanggal_catat'])); ?></td>
                            <td><?= $data['total_m3']; ?> m³</td>
                            <td>Rp <?= number_format($data['total_tagihan'], 0, ',', '.'); ?></td>
                            <td class="fw-bold <?= $warna ?>"><?= $status ?></td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="6" class="text-center">Data tidak ditemukan untuk tahun <?= $tahun_pilihan ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
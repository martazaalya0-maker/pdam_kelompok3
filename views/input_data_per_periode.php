<?php
session_start();
require_once '../config/database.php';

// 1. PROSES FILTER BULAN & TAHUN
$bulan_pilihan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_pilihan = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$tarif_per_m3 = 4000;
$biaya_beban  = 20000;

$query = "SELECT p.*, pl.nama_pelanggan, pl.golongan, 
                 t.total_m3, t.total_tagihan, t.status_bayar, t.tanggal_bayar
          FROM pemakaian p
          JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
          LEFT JOIN tagihan t ON p.id_pelanggan = t.id_pelanggan 
          AND MONTH(p.tanggal_catat) = MONTH(p.tanggal_catat) 
          AND YEAR(p.tanggal_catat) = YEAR(p.tanggal_catat)
          WHERE MONTH(p.tanggal_catat) = '$bulan_pilihan' 
          AND YEAR(p.tanggal_catat) = '$tahun_pilihan'";

$result = mysqli_query($conn, $query);

$daftar_bulan = [
    "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", 
    "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", 
    "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Per Periode - PDAM Tirta Jaya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px 20px; transition: 0.3s; }
        .sidebar a:hover { background-color: #006666; }
        .main-content { margin-left: 260px; padding: 20px; }
        .sidebar a.active { background-color: #006666; font-weight: bold; }
        @media print { .sidebar, .filter-card, .btn-print, hr { display: none !important; } .main-content { margin-left: 0 !important; } }
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
    <h4>Laporan Per Periode</h4>
    <div class="card mb-4 filter-card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Bulan</label>
                    <select name="bulan" class="form-select">
                        <?php foreach ($daftar_bulan as $key => $val): ?>
                            <option value="<?= $key; ?>" <?= $key == $bulan_pilihan ? 'selected' : ''; ?>><?= $val; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Tahun</label>
                    <select name="tahun" class="form-select">
                        <?php for($i = date('Y'); $i >= date('Y')-4; $i--): ?>
                            <option value="<?= $i; ?>" <?= $i == $tahun_pilihan ? 'selected' : ''; ?>><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn text-white w-50 me-2" style="background-color: #008b8b;"><i class="bi bi-search"></i> Cari</button>
                    <button type="button" onclick="window.print()" class="btn btn-secondary w-50 btn-print"><i class="bi bi-printer"></i> Cetak</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #008b8b;">
                        <tr>
                            <th>No</th><th>Nama</th><th>Gol</th><th>Volume</th><th>Total Tagihan</th><th>Status</th><th>Tgl Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
    if (mysqli_num_rows($result) > 0):
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)): 
            // Jika data di tabel tagihan kosong (belum ada tagihan), gunakan '-'
            $volume = !empty($row['total_m3']) ? $row['total_m3'] . " m³" : "-";
            $total_t = !empty($row['total_tagihan']) ? "Rp " . number_format($row['total_tagihan'], 0, ',', '.') : "-";
            
            // Logika Status
            $status = !empty($row['status_bayar']) ? $row['status_bayar'] : 'Belum Dibayar';
            $warna = ($status == 'Lunas') ? 'text-success' : 'text-danger';
            $tgl = !empty($row['tanggal_bayar']) ? date('d-m-Y', strtotime($row['tanggal_bayar'])) : '-';
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama_pelanggan']; ?></td>
        <td><?= $row['golongan']; ?></td>
        <td><?= $volume; ?></td>
        <td><?= $total_t; ?></td>
        <td class="fw-bold <?= $warna ?>"><?= $status ?></td>
        <td><?= $tgl ?></td>
    </tr>
    <?php endwhile; else: ?>
    <tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
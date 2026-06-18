<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin PDAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px 20px; transition: 0.3s; }
        .sidebar a:hover { background-color: #006666; }
        .main-content { margin-left: 260px; padding: 20px; }
        .card-menu { border: none; color: white; padding: 30px; border-radius: 5px; margin-bottom: 20px; transition: 0.3s; }
        .card-menu:hover { transform: scale(1.02); }
    </style>
</head>
<body class="bg-light">

<div class="sidebar">
    <div class="p-3"><h5>PDAM TIRTA JAYA MANDIRI</h5></div>
    <hr>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="views/input_data_pelanggan.php"><i class="bi bi-people"></i> Input Data Pelanggan</a>
    <a href="views/input_meter_air.php"><i class="bi bi-speedometer"></i> Input Meter Air</a>
    <a href="tagihan.php"><i class="bi bi-receipt"></i> Searching Tagihan</a>
    <a href="views/input_data_per_periode.php"><i class="bi bi-calendar-check"></i> Laporan Per Periode</a>
    <a href="views/input_data_per_tahun.php"><i class="bi bi-calendar-event"></i> Laporan Per Tahun</a>
    <a href="views/laporan_tertinggi.php"><i class="bi bi-graph-up-arrow"></i> Laporan Tertinggi</a>
    <hr>
    <a href="views/auth/logout.php" class="text-white"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between mb-4">
        <h4>Dashboard Utama</h4>
        <span>Admin <i class="bi bi-person-circle"></i></span>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-menu bg-warning"><h5>KONFIRMASI PASANG BARU</h5><i class="bi bi-envelope fs-1"></i></div>
        </div>
        <div class="col-md-4">
            <div class="card-menu bg-info"><h5>KELUHAN PELANGGAN</h5><i class="bi bi-envelope-exclamation fs-1"></i></div>
        </div>
        <div class="col-md-4">
            <div class="card-menu bg-primary"><h5>INPUT PENGUMUMAN</h5><i class="bi bi-pencil fs-1"></i></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card-menu bg-success"><h5>CHATTING PELANGGAN</h5><i class="bi bi-chat-dots fs-1"></i></div>
        </div>
    </div>
</div>

</body>
</html>
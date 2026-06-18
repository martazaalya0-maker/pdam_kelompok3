<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Meter Air - PDAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #008b8b; min-height: 100vh; color: white; width: 260px; position: fixed; }
        .sidebar .brand { padding: 20px; font-weight: bold; border-bottom: 1px solid #007777; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px 20px; transition: 0.3s; }
        .sidebar a:hover { background-color: #006666; }
        .main-content { margin-left: 260px; padding: 25px; }
        .top-bar { background: white; padding: 15px 25px; border-bottom: 1px solid #ddd; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body class="bg-light">

<div class="sidebar">
    <div class="brand">PDAM TIRTA JAYA MANDIRI</div>
   <a href="../dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="input_data_pelanggan.php"><i class="bi bi-people"></i> Input Data Pelanggan</a>
    <a href="input_meter_air.php"><i class="bi bi-speedometer"></i> Input Meter Air</a>
    <a href="../tagihan.php"><i class="bi bi-receipt"></i> Searching Tagihan</a>
    <a href="input_data_per_periode.php"><i class="bi bi-calendar-check"></i> Laporan Per Periode</a>
    <a href="input_data_per_tahun.php"><i class="bi bi-calendar-event"></i> Laporan Per Tahun</a>
    <a href="laporan_tertinggi.php" class="active"><i class="bi bi-graph-up-arrow"></i> Laporan Tertinggi</a>
    <hr>
    <a href="auth/logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <div class="top-bar">
        <h4>Input Meter Air</h4>
        <span>Admin <i class="bi bi-person-circle"></i></span>
    </div>

    <div class="container-fluid">
        <div class="card p-4 shadow-sm">
            <h5>Form Input Pemakaian Bulanan</h5>
            <hr>
            <?php
            session_start();
            require_once '../config/database.php';
            $pelanggan = mysqli_query($conn, "SELECT id_pelanggan, nama_pelanggan FROM pelanggan");
            ?>
            
            <form action="../controllers/BillingController.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="id_pelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php while($p = mysqli_fetch_assoc($pelanggan)) { ?>
                            <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama_pelanggan'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meter Awal</label>
                        <input type="number" name="meter_awal" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meter Akhir</label>
                        <input type="number" name="meter_akhir" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bulan/Tahun Tagihan</label>
                    <input type="text" name="bulan" class="form-control" placeholder="Contoh: Juni 2026" required>
                </div>
                <button type="submit" name="hitung" class="btn btn-primary w-100">
                    <i class="bi bi-calculator"></i> Hitung & Simpan Tagihan
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Pelanggan - PDAM</title>
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
        <h4>Input Data Pelanggan</h4>
        <span>Admin <i class="bi bi-person-circle"></i></span>
    </div>

    <div class="container-fluid">
        <div class="card p-4 shadow-sm mb-4">
            <h5>Tambah Pelanggan Baru</h5>
            <hr>
            <form action="../controllers/PelangganController.php" method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Golongan</label>
                    <select name="golongan" class="form-select">
                        <option value="Rumah Tangga">Rumah Tangga</option>
                        <option value="industri">industri</option>
                        <option value="instansi pemerintah">Intansi pemerintah</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card p-4 shadow-sm">
            <h5>Daftar Pelanggan</h5>
            <table class="table table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>ID</th><th>Nama Pelanggan</th><th>Golongan</th><th>Nomor HP</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../config/database.php';
                    $query = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
                    while ($data = mysqli_fetch_assoc($query)) {
                        echo "<tr>
                            <td>{$data['id_pelanggan']}</td>
                            <td>{$data['nama_pelanggan']}</td>
                            <td>{$data['golongan']}</td>
                            <td>{$data['no_hp']}</td>
                            <td>
                                <a href='../controllers/PelangganController.php?hapus={$data['id_pelanggan']}' 
                                   class='btn btn-sm btn-outline-danger' 
                                   onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                   <i class='bi bi-trash'></i>
                                </a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
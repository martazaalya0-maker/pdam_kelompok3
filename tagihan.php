<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Searching Tagihan - PDAM</title>
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
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="views/input_data_pelanggan.php"><i class="bi bi-people"></i> Input Data Pelanggan</a>
    <a href="views/input_meter_air.php"><i class="bi bi-speedometer"></i> Input Meter Air</a>
    <a href="tagihan.php" style="background:#006666;"><i class="bi bi-receipt"></i> Searching Tagihan</a>
    <a href="views/input_data_per_periode.php"><i class="bi bi-calendar-check"></i> Laporan Per Periode</a>
    <a href="views/input_data_per_tahun.php"><i class="bi bi-calendar-event"></i> Laporan Per Tahun</a>
    <a href="views/laporan_tertinggi.php"><i class="bi bi-graph-up-arrow"></i> Laporan Tertinggi</a>
    <hr>
    <a href="views/auth/logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
    <div class="top-bar">
        <h4>Searching Tagihan Pelanggan</h4>
        <span>Admin <i class="bi bi-person-circle"></i></span>
    </div>

    <div class="container-fluid">
        <div class="card p-4 shadow-sm mb-4">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-10">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan nama pelanggan..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                </div>
            </form>
        </div>

        <div class="card p-4 shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Tagihan</th><th>Nama Pelanggan</th><th>Total m3</th><th>Total Tagihan</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config/database.php';
                    $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
                    
                    $sql = "SELECT tagihan.*, pelanggan.nama_pelanggan 
                            FROM tagihan 
                            JOIN pelanggan ON tagihan.id_pelanggan = pelanggan.id_pelanggan 
                            WHERE pelanggan.nama_pelanggan LIKE '%$keyword%'
                            ORDER BY tagihan.id_tagihan DESC";
                    
                    $result = mysqli_query($conn, $sql);
                    
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            // Gunakan strcasecmp agar pengecekan status tidak case-sensitive
                            $is_lunas = (strcasecmp($data['status_bayar'], 'Lunas') == 0);
                            $status_teks = $is_lunas ? "Sudah Dibayar" : "Belum Dibayar";
                            $status_color = $is_lunas ? "text-success" : "text-danger";

                            echo "<tr>
                                <td>{$data['id_tagihan']}</td>
                                <td>{$data['nama_pelanggan']}</td>
                                <td>{$data['total_m3']}</td>
                                <td>Rp " . number_format($data['total_tagihan'], 0, ',', '.') . "</td>
                                <td class='fw-bold $status_color'>{$status_teks}</td>
                                <td>";
                                
                                if (!$is_lunas) {
                                    echo "<a href='controllers/BayarController.php?id={$data['id_tagihan']}' 
                                           class='btn btn-sm btn-success' 
                                           onclick='return confirm(\"Konfirmasi pembayaran untuk tagihan ini?\")'>
                                           <i class='bi bi-cash-coin'></i> Bayar
                                         </a>";
                                } else {
                                    echo "<span class='text-muted small'>Lunas</span>";
                                }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
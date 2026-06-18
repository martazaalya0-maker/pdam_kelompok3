<?php
session_start();
require_once '../config/database.php';

// Menangkap input bulan dan tahun, default ke bulan ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Per Bulan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="card p-4 shadow-sm">
    <h3>Laporan Pemakaian Air Bulan <?= $bulan ?>/<?= $tahun ?></h3>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-auto">
            <select name="bulan" class="form-control">
                <?php for($m=1; $m<=12; $m++): ?>
                    <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-auto">
            <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Pelanggan</th>
                <th>Tanggal Catat</th>
                <th>Pemakaian (m3)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query mengambil data berdasarkan bulan dan tahun dari kolom tanggal_catat
            $sql = "SELECT * FROM pemakaian 
                    WHERE MONTH(tanggal_catat) = '$bulan' 
                    AND YEAR(tanggal_catat) = '$tahun'";
            
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id_pelanggan']}</td>
                        <td>{$row['tanggal_catat']}</td>
                        <td>{$row['total_m3']} m3</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada data pada bulan ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button onclick="window.print()" class="btn btn-success">Cetak Laporan</button>
</div>

</body>
</html>
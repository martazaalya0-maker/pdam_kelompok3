<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id_tagihan = mysqli_real_escape_string($conn, $_GET['id']);

    mysqli_begin_transaction($conn);

    try {
        // 1. Ambil data tagihan terlebih dahulu untuk referensi input ke pemakaian
        $sql_tagihan = "SELECT * FROM tagihan WHERE id_tagihan = '$id_tagihan'";
        $res_tagihan = mysqli_query($conn, $sql_tagihan);
        $data = mysqli_fetch_assoc($res_tagihan);

        // 2. Update status bayar di tabel tagihan
        $query_update = "UPDATE tagihan SET status_bayar = 'Lunas', tanggal_bayar = NOW() WHERE id_tagihan = '$id_tagihan'";
        mysqli_query($conn, $query_update);

        // 3. Input ke tabel pemakaian (sesuaikan nama kolom dengan struktur tabel Anda)
        // Kita menggunakan NOW() sebagai tanggal catat
        $query_insert = "INSERT INTO pemakaian (id_pelanggan, meter_awal, meter_akhir, tanggal_catat) 
                         VALUES ('".$data['id_pelanggan']."', '".$data['meter_awal']."', '".$data['meter_akhir']."', NOW())";
        mysqli_query($conn, $query_insert);

        mysqli_commit($conn);
        echo "<script>alert('Pembayaran sukses & data pemakaian terinput!'); window.location='../tagihan.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.location='../tagihan.php';</script>";
    }
}
?>
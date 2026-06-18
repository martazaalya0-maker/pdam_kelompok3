<?php
require_once '../config/database.php';

if (isset($_POST['hitung'])) {
    // 1. Ambil data dari form
    $id_pelanggan = $_POST['id_pelanggan'];
    $meter_awal   = (int)$_POST['meter_awal'];
    $meter_akhir  = (int)$_POST['meter_akhir'];
    // $bulan sudah tidak dipakai di insert, namun tetap bisa disimpan jika ingin
    
    // 2. Validasi
    if ($meter_akhir < $meter_awal) {
        echo "<script>alert('Meter akhir tidak boleh lebih kecil dari meter awal!'); window.history.back();</script>";
        exit;
    }

    $total_m3 = $meter_akhir - $meter_awal;

    // 3. Ambil tarif
    $query = mysqli_query($conn, "SELECT tarif.harga_per_m3, tarif.biaya_admin 
                                  FROM pelanggan 
                                  JOIN tarif ON pelanggan.golongan = tarif.golongan 
                                  WHERE pelanggan.id_pelanggan = '$id_pelanggan'");
    
    $data_tarif = mysqli_fetch_assoc($query);

    if (!$data_tarif) {
        echo "<script>alert('Data tarif untuk golongan ini belum diatur di database!'); window.history.back();</script>";
        exit;
    }

    // 4. Hitung total tagihan
    $total_tagihan = ($total_m3 * $data_tarif['harga_per_m3']) + $data_tarif['biaya_admin'];

    // 5. Simpan ke tabel tagihan
    // Field: id_tagihan(AI), id_pemakaian, id_pelanggan, total_m3, total_tagihan, status_bayar, tanggal_bayar
    // Catatan: id_pemakaian bisa kita isi dengan id_pelanggan atau kosongkan jika auto increment
    $status_bayar = 'Belum Bayar';
    $tanggal_bayar = NULL; // Karena belum bayar

    $insert = mysqli_query($conn, "INSERT INTO tagihan 
                                   (id_pelanggan, total_m3, total_tagihan, status_bayar, tanggal_bayar) 
                                   VALUES 
                                   ('$id_pelanggan', '$total_m3', '$total_tagihan', '$status_bayar', NULL)");

    if ($insert) {
        echo "<script>
                alert('Tagihan berhasil dibuat!\\nTotal Tagihan: Rp " . number_format($total_tagihan, 0, ',', '.') . "'); 
                window.location='../views/input_meter_air.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
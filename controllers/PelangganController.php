<?php
// Koneksi database
require_once '../config/database.php';

// Memeriksa apakah tombol 'simpan' telah ditekan
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $gol  = $_POST['golongan'];
    $hp   = $_POST['no_hp'];

    // Menjalankan query dengan pengecekan error
    $sql = "INSERT INTO pelanggan (nama_pelanggan, golongan, no_hp) VALUES ('$nama', '$gol', '$hp')";
    
    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, kembali ke halaman pelanggan
        header("Location: ../views/input_data_pelanggan.php?status=success");
    } else {
        // Jika gagal, tampilkan error MySQL-nya
        echo "Error Database: " . mysqli_error($conn);
    }
}
?>
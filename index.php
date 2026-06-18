<?php
session_start();

// Cek apakah user sudah memiliki session login yang aktif
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] === true) {
    
    // Jika sudah login, cek rolenya untuk diarahkan ke dashboard yang tepat
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
        exit();
    } else if ($_SESSION['role'] === 'pelanggan') {
        header("Location: dashboard_pelanggan.php");
        exit();
    }
}

// Jika belum login atau tidak ada session, lempar otomatis ke halaman login utama
header("Location: views/auth/login.php");
exit();
?>
# Metamedia PDAM Water Management System

**Metamedia PDAM Water Management System** adalah sistem informasi manajemen berbasis web yang dirancang untuk membantu proses administrasi dan pelayanan pelanggan PDAM secara terintegrasi. Sistem ini memudahkan pengelolaan data pelanggan, pencatatan meter air, transaksi pembayaran rekening, hingga penyusunan laporan secara cepat dan akurat.

---

## 🚀 Fitur Utama

Sistem ini dilengkapi dengan berbagai fitur yang mendukung operasional PDAM, di antaranya:

### Dashboard Admin

* Menampilkan ringkasan jumlah pelanggan.
* Statistik tagihan yang telah dibayar dan belum dibayar.
* Total pendapatan PDAM.
* Grafik pembayaran pelanggan secara real-time.

### Manajemen Pelanggan

* Tambah, ubah, hapus, dan lihat data pelanggan.
* Pengelolaan data alamat, nomor sambungan, golongan tarif, dan status pelanggan.

### Manajemen Petugas

* Pengelolaan data admin dan petugas pencatat meter.
* Hak akses sesuai dengan peran masing-masing pengguna.

### Pencatatan Meter Air

* Input angka meter awal dan meter akhir setiap bulan.
* Perhitungan otomatis jumlah pemakaian air.
* Riwayat pencatatan meter pelanggan.

### Sistem Tagihan

* Pembuatan tagihan otomatis berdasarkan pemakaian air.
* Perhitungan biaya sesuai tarif pelanggan.
* Status pembayaran (Lunas/Belum Lunas).

### Sistem Pembayaran

* Pencatatan pembayaran rekening air.
* Penyimpanan bukti pembayaran.
* Riwayat transaksi pembayaran pelanggan.

### Perhitungan Denda

* Perhitungan denda otomatis apabila pembayaran melewati jatuh tempo.
* Total tagihan akan diperbarui secara otomatis.

### Laporan Komprehensif

* Laporan data pelanggan.
* Laporan pemakaian air.
* Laporan pembayaran bulanan.
* Laporan pembayaran tahunan.
* Laporan tunggakan pelanggan.
* Laporan pendapatan PDAM.
* Laporan pelanggan aktif dan nonaktif.

### Ekspor Data

* Ekspor laporan ke format Microsoft Excel.
* Cetak laporan dalam format PDF.
* Cetak bukti pembayaran.

---

## 🛠️ Teknologi yang Digunakan

**Backend**

* PHP (Native)

**Database**

* MySQL

**Frontend**

* HTML5
* CSS3
* Bootstrap 5
* JavaScript

**Server**

* XAMPP (Apache & MySQL)

---

## 🏗️ Struktur Proyek

```plaintext
/admin
├── dashboard.php              # Dashboard Admin
├── pelanggan.php              # Data Pelanggan
├── petugas.php                # Data Petugas
├── tarif.php                  # Data Tarif Air
├── meter_air.php              # Input Meter Air
├── tagihan.php                # Data Tagihan
├── pembayaran.php             # Pembayaran Rekening
├── laporan_pelanggan.php      # Laporan Pelanggan
├── laporan_pemakaian.php      # Laporan Pemakaian Air
├── laporan_pembayaran.php     # Laporan Pembayaran
├── laporan_tunggakan.php      # Laporan Tunggakan
├── laporan_pendapatan.php     # Laporan Pendapatan
├── export_excel.php           # Ekspor Data Excel
└── ...

/config
└── database.php               # Konfigurasi Database

/auth
├── login.php                  # Login Sistem
└── logout.php                 # Logout
```

---

## ⚙️ Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/pdam-management-system.git
```

### 2. Siapkan Database

* Jalankan XAMPP.
* Aktifkan Apache dan MySQL.
* Buka phpMyAdmin.
* Buat database baru, misalnya:

```
db_pdam
```

* Import file database (.sql) yang tersedia pada folder proyek.

### 3. Konfigurasi Database

Buka file:

```
config/database.php
```

Kemudian sesuaikan konfigurasi berikut dengan server lokal Anda:

* Host
* Username
* Password
* Nama Database

### 4. Login Sistem

**Admin**

```
Username : admin
Password : admin123
```

**Petugas**

```
Username : petugas01
Password : petugas123
```

### 5. Menjalankan Aplikasi

* Salin folder proyek ke dalam folder **htdocs** pada XAMPP.
* Jalankan Apache dan MySQL.
* Buka browser dan akses:

```
http://localhost/pdam
```

---

## 📊 Modul Sistem

* Login Multi User
* Dashboard
* Data Pelanggan
* Data Petugas
* Data Tarif Air
* Input Meter Air
* Perhitungan Pemakaian Air
* Tagihan Otomatis
* Pembayaran Rekening
* Perhitungan Denda
* Laporan Bulanan
* Laporan Tahunan
* Laporan Pendapatan
* Laporan Tunggakan
* Cetak Bukti Pembayaran
* Ekspor Excel
* Logout

---

## 🤝 Kontribusi

Proyek ini dikembangkan sebagai media pembelajaran sekaligus implementasi Sistem Informasi Manajemen PDAM berbasis web. Masukan, saran, dan pengembangan fitur sangat terbuka bagi siapa saja. Silakan melakukan **Fork** repository dan mengirimkan **Pull Request** untuk berkontribusi dalam pengembangan sistem.

---

## 📝 Lisensi

Proyek ini bersifat **Open Source** dan dapat digunakan untuk keperluan pembelajaran, penelitian, maupun pengembangan sistem informasi dengan tetap mencantumkan sumber pengembang apabila digunakan kembali.

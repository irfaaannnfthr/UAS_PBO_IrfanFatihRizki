<?php

// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  File    : koneksi.php — Konfigurasi Koneksi Database
// ============================================================

$host     = 'localhost';
$user     = 'root';
$password = '';           // default Laragon kosong
$database = 'DB_UAS_PBO_TRPL1A_IrfanFatihRizki';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');
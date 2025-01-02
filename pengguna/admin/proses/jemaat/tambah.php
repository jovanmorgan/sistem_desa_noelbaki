<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_rayon = $_POST['id_rayon'];
$id_kepala_keluarga = $_POST['id_kepala_keluarga'];
$nama_lengkap = $_POST['nama_lengkap'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$status_babtis = $_POST['status_babtis'];
$status_sidi = $_POST['status_sidi'];
$status_nikah = $_POST['status_nikah'];

// Lakukan validasi data
if (empty($id_rayon) || empty($id_kepala_keluarga) || empty($nama_lengkap) || empty($jenis_kelamin) || empty($alamat) || empty($no_hp) || empty($status_babtis) || empty($status_sidi) || empty($status_nikah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO jemaat (id_rayon, id_kepala_keluarga, nama_lengkap, jenis_kelamin, alamat, no_hp, status_babtis, status_sidi, status_nikah)
        VALUES ('$id_rayon', '$id_kepala_keluarga', '$nama_lengkap', '$jenis_kelamin', '$alamat', '$no_hp', '$status_babtis', '$status_sidi', '$status_nikah')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

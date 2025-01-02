<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lengkap = $_POST['nama_lengkap'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$umur = $_POST['umur'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($jenis_kelamin) || empty($alamat) || empty($umur)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO majelis (nama_lengkap, jenis_kelamin, alamat, umur)
        VALUES ('$nama_lengkap', '$jenis_kelamin', '$alamat', '$umur')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

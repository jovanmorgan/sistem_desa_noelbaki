<?php
include '../../../../keamanan/koneksi.php';

$id_kepala_keluarga = $_POST['id_kepala_keluarga']; // Pastikan ID kepala_keluarga dikirim untuk proses update
$nama_lengkap = $_POST['nama_lengkap'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$id_rayon = $_POST['id_rayon'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($jenis_kelamin) || empty($alamat) || empty($id_rayon)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE kepala_keluarga 
            SET nama_lengkap = '$nama_lengkap', 
                jenis_kelamin = '$jenis_kelamin', 
                alamat = '$alamat', 
                id_rayon = '$id_rayon'
          WHERE id_kepala_keluarga = '$id_kepala_keluarga'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

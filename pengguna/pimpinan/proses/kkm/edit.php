<?php
include '../../../../keamanan/koneksi.php';

$id_kkm = $_POST['id_kkm'];
$status_validasi = $_POST['status_validasi'];
// Lakukan validasi data
if (empty($id_kkm) || empty($status_validasi)) {
    echo "data_tidak_lengkap";
    exit();
}


// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE keluarga_kurang_mampu 
            SET status_validasi = '$status_validasi'
          WHERE id_kkm = '$id_kkm'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

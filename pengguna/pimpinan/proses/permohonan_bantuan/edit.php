<?php
include '../../../../keamanan/koneksi.php';

$id_permohonan_bantuan = $_POST['id_permohonan_bantuan'];
$status_validasi = $_POST['status_validasi'];
// Lakukan validasi data
if (empty($id_permohonan_bantuan) || empty($status_validasi)) {
    echo "data_tidak_lengkap";
    exit();
}


// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE permohonan_bantuan 
            SET status_validasi = '$status_validasi'
          WHERE id_permohonan_bantuan = '$id_permohonan_bantuan'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

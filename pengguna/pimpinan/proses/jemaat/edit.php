<?php
include '../../../../keamanan/koneksi.php';

$id_jemaat = $_POST['id_jemaat'];
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

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE jemaat 
            SET id_rayon = '$id_rayon', 
                id_kepala_keluarga = '$id_kepala_keluarga', 
                nama_lengkap = '$nama_lengkap', 
                jenis_kelamin = '$jenis_kelamin', 
                alamat = '$alamat', 
                no_hp = '$no_hp', 
                status_babtis = '$status_babtis', 
                status_sidi = '$status_sidi', 
                status_nikah = '$status_nikah'
          WHERE id_jemaat = '$id_jemaat'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

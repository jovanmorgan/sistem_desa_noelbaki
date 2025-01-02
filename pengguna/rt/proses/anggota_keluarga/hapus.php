<?php
include '../../../../keamanan/koneksi.php';

// Terima id_anggota_keluarga yang akan dihapus dari formulir HTML
$id_anggota_keluarga = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_anggota_keluarga)) {
    echo "data_tidak_lengkap";
    exit();
}

// Query untuk menghapus data anggota_keluarga yang memiliki id_anggota_keluarga yang sama
$query_delete_anggota_keluarga = "DELETE FROM anggota_keluarga WHERE id_anggota_keluarga = '$id_anggota_keluarga'";

// Jalankan query untuk menghapus data anggota_keluarga
if (mysqli_query($koneksi, $query_delete_anggota_keluarga)) {
    echo "success";
} else {
    echo "error_hapus_anggota_keluarga: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);

<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kepala_keluarga yang akan dihapus dari formulir HTML
$id_kepala_keluarga = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kepala_keluarga)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kepala_keluarga berdasarkan ID
$query_delete_kepala_keluarga = "DELETE FROM kepala_keluarga WHERE id_kepala_keluarga = '$id_kepala_keluarga'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kepala_keluarga)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

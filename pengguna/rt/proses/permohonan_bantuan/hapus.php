<?php
include '../../../../keamanan/koneksi.php';

// Terima ID permohonan_bantuan yang akan dihapus dari formulir HTML
$id_permohonan_bantuan = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_permohonan_bantuan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data permohonan_bantuan berdasarkan ID
$query_delete_permohonan_bantuan = "DELETE FROM permohonan_bantuan WHERE id_permohonan_bantuan = '$id_permohonan_bantuan'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_permohonan_bantuan)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

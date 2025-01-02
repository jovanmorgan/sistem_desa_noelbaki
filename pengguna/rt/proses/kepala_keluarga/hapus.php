<?php
include '../../../../keamanan/koneksi.php';

// Terima id_kepala_keluarga yang akan dihapus dari formulir HTML
$id_kepala_keluarga = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kepala_keluarga)) {
    echo "data_tidak_lengkap";
    exit();
}

// Query untuk menghapus data kepala_keluarga yang memiliki id_kepala_keluarga yang sama
$query_delete_kepala_keluarga = "DELETE FROM kepala_keluarga WHERE id_kepala_keluarga = '$id_kepala_keluarga'";

// Jalankan query untuk menghapus data kepala_keluarga
if (mysqli_query($koneksi, $query_delete_kepala_keluarga)) {
    // Setelah data kepala_keluarga dihapus, lanjutkan untuk menghapus data anggota_keluarga
    $query_delete_anggota_keluarga = "DELETE FROM anggota_keluarga WHERE id_kepala_keluarga = '$id_kepala_keluarga'";
    if (mysqli_query($koneksi, $query_delete_anggota_keluarga)) {
        echo "success";
    } else {
        echo "error_hapus_anggota_keluarga: " . mysqli_error($koneksi);
    }
} else {
    echo "error_hapus_kepala_keluarga: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);

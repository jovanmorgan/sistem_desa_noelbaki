<?php
include '../../../../keamanan/koneksi.php';

// Terima id_rt yang akan dihapus dari formulir HTML
$id_rt = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_rt)) {
    echo "data_tidak_lengkap";
    exit();
}

// Query untuk menghapus data rt yang memiliki id_rt yang sama
$query_delete_rt = "DELETE FROM rt WHERE id_rt = '$id_rt'";

// Jalankan query untuk menghapus data rt
if (mysqli_query($koneksi, $query_delete_rt)) {
    // Setelah data rt dihapus, lanjutkan untuk menghapus data kepala_keluarga
    $query_delete_kk = "DELETE FROM kepala_keluarga WHERE id_rt = '$id_rt'";
    if (mysqli_query($koneksi, $query_delete_kk)) {
        // Setelah data kepala_keluarga dihapus, lanjutkan untuk menghapus data anggota_keluarga
        $query_delete_anggota_keluarga = "DELETE FROM anggota_keluarga WHERE id_rt = '$id_rt'";
        if (mysqli_query($koneksi, $query_delete_anggota_keluarga)) {
            echo "success";
        } else {
            echo "error_hapus_anggota_keluarga: " . mysqli_error($koneksi);
        }
    } else {
        echo "error_hapus_kepala_keluarga: " . mysqli_error($koneksi);
    }
} else {
    echo "error_hapus_rt: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);

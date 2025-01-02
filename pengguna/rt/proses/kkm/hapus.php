<?php
include '../../../../keamanan/koneksi.php';

// Terima id_kkm yang akan dihapus dari formulir HTML
$id_kkm = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kkm)) {
    echo "data_tidak_lengkap";
    exit();
}

// Query untuk menghapus data keluarga_kurang_mampu yang memiliki id_kkm yang sama
$query_delete_keluarga_kurang_mampu = "DELETE FROM keluarga_kurang_mampu WHERE id_kkm = '$id_kkm'";

// Jalankan query untuk menghapus data keluarga_kurang_mampu
if (mysqli_query($koneksi, $query_delete_keluarga_kurang_mampu)) {
    // Setelah data keluarga_kurang_mampu dihapus, lanjutkan untuk menghapus data permohonan_bantuan
    $query_delete_permohonan_bantuan = "DELETE FROM permohonan_bantuan WHERE id_kkm = '$id_kkm'";
    if (mysqli_query($koneksi, $query_delete_permohonan_bantuan)) {
        echo "success";
    } else {
        echo "error_hapus_permohonan_bantuan: " . mysqli_error($koneksi);
    }
} else {
    echo "error_hapus_keluarga_kurang_mampu: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
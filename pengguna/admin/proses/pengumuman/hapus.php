<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pengumuman yang akan dihapus dari formulir HTML
$id_pengumuman = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pengumuman)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mendapatkan path foto yang akan dihapus
$query_get_foto = "SELECT foto FROM pengumuman WHERE id_pengumuman = ?";
$stmt = mysqli_prepare($koneksi, $query_get_foto);
mysqli_stmt_bind_param($stmt, 'i', $id_pengumuman);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$foto_to_delete = $row['foto'];

// Buat query SQL untuk memeriksa apakah ada data lain yang menggunakan file foto yang akan dihapus
$query_check_foto = "SELECT COUNT(*) AS total FROM pengumuman WHERE foto = ?";
$stmt_check = mysqli_prepare($koneksi, $query_check_foto);
mysqli_stmt_bind_param($stmt_check, 's', $foto_to_delete);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row_check = mysqli_fetch_assoc($result_check);
$total_pengguna_foto = $row_check['total'];

// Jika tidak ada data lain yang menggunakan file foto, hapus foto
if ($total_pengguna_foto <= 1 && file_exists($foto_to_delete)) {
    // Hapus file foto dari folder
    if (!unlink($foto_to_delete)) {
        echo "error"; // Error saat menghapus file
        exit();
    }
}

// Buat query SQL untuk menghapus data pengumuman berdasarkan ID
$query_delete_pengumuman = "DELETE FROM pengumuman WHERE id_pengumuman = ?";
$stmt_delete = mysqli_prepare($koneksi, $query_delete_pengumuman);
mysqli_stmt_bind_param($stmt_delete, 'i', $id_pengumuman);
if (mysqli_stmt_execute($stmt_delete)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

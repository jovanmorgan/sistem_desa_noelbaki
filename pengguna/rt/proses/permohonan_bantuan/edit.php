<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_permohonan_bantuan = $_POST['id_permohonan_bantuan']; // ID unik untuk data yang akan diedit
$id_rt = $_POST['id_rt'];
$id_kkm = $_POST['id_kkm'];
$jenis_bantuan = $_POST['jenis_bantuan'];

// Lakukan validasi data
if (empty($id_permohonan_bantuan) || empty($id_rt) || empty($id_kkm) || empty($jenis_bantuan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Ambil data id_kepala_keluarga berdasarkan id_kkm
$query_kepala_keluarga = "SELECT id_kepala_keluarga FROM keluarga_kurang_mampu WHERE id_kkm = '$id_kkm'";
$result_kepala_keluarga = mysqli_query($koneksi, $query_kepala_keluarga);

// Periksa apakah data ditemukan
if (mysqli_num_rows($result_kepala_keluarga) > 0) {
    $row = mysqli_fetch_assoc($result_kepala_keluarga);
    $id_kepala_keluarga = $row['id_kepala_keluarga'];
} else {
    echo "data_kepala_keluarga_tidak_ditemukan";
    exit();
}

// Periksa apakah jenis_bantuan yang baru sudah ada di database
$check_query = "SELECT * FROM permohonan_bantuan 
                WHERE jenis_bantuan = '$jenis_bantuan' AND id_kkm = '$id_kkm' AND id_permohonan_bantuan != '$id_permohonan_bantuan'";
$result_check = mysqli_query($koneksi, $check_query);

if (mysqli_num_rows($result_check) > 0) {
    echo "data_bantuan_sudah_ada"; // Data dengan kombinasi baru sudah ada
    exit();
}

// Update data di tabel permohonan_bantuan
$query_update = "UPDATE permohonan_bantuan 
                 SET id_rt = '$id_rt', id_kkm = '$id_kkm', jenis_bantuan = '$jenis_bantuan', id_kepala_keluarga = '$id_kepala_keluarga'
                 WHERE id_permohonan_bantuan = '$id_permohonan_bantuan'";

if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_rt = $_POST['id_rt'];
$id_kkm = $_POST['id_kkm'];
$jenis_bantuan = $_POST['jenis_bantuan'];
$status_validasi = "Dalam Proses";

// Lakukan validasi data
if (empty($id_rt) || empty($id_kkm) || empty($jenis_bantuan)) {
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

// Cek apakah jenis_bantuan sudah ada di database
$check_query_permohonan_bantuan = "SELECT * FROM permohonan_bantuan WHERE jenis_bantuan = '$jenis_bantuan' AND id_kkm = '$id_kkm'";
$result_permohonan_bantuan = mysqli_query($koneksi, $check_query_permohonan_bantuan);
if (mysqli_num_rows($result_permohonan_bantuan) > 0) {
    echo "data_bantuan_sudah_ada"; // Kirim respon "data_sudah_ada" jika data sudah terdaftar
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO permohonan_bantuan (id_rt, id_kkm, jenis_bantuan, id_kepala_keluarga, status_validasi)
        VALUES ('$id_rt', '$id_kkm', '$jenis_bantuan', '$id_kepala_keluarga', '$status_validasi')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

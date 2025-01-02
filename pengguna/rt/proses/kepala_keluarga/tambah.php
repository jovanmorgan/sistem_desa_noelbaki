<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lengkap = $_POST['nama_lengkap'];
$id_rt = $_POST['id_rt'];
$nomor_induk_kartu_keluarga = $_POST['nomor_induk_kartu_keluarga'];
$nik_kepala_keluarga = $_POST['nik_kepala_keluarga'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$pekerjaan = $_POST['pekerjaan'];
$agama = $_POST['agama'];
$pendidikan = $_POST['pendidikan'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($id_rt) || empty($nomor_induk_kartu_keluarga) || empty($nik_kepala_keluarga) || empty($jenis_kelamin) || empty($tempat_lahir) || empty($pekerjaan) || empty($agama) || empty($pendidikan) || empty($tanggal_lahir)) {
    echo "data_tidak_lengkap";
    exit();
}

// vadisai nomor_induk_kartu_keluarga sudah di gunakan
$check_query = "SELECT * FROM kepala_keluarga WHERE nomor_induk_kartu_keluarga = '$nomor_induk_kartu_keluarga'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "nikk_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// nomor_induk_kartu_keluarga wajib 16 digit
if (strlen($nomor_induk_kartu_keluarga) != 16) {
    echo "nikk_wajib_16_digit";
    exit();
}

// vadisai nik_kepala_keluarga sudah di gunakan
$check_query = "SELECT * FROM kepala_keluarga WHERE nik_kepala_keluarga = '$nik_kepala_keluarga'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "nkk_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// nik_kepala_keluarga wajib 16 digit
if (strlen($nik_kepala_keluarga) != 16) {
    echo "nkk_wajib_16_digit";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO kepala_keluarga (nama_lengkap, id_rt, nomor_induk_kartu_keluarga, nik_kepala_keluarga, jenis_kelamin, tempat_lahir, pekerjaan, agama, pendidikan, tanggal_lahir)
        VALUES ('$nama_lengkap', '$id_rt', '$nomor_induk_kartu_keluarga', '$nik_kepala_keluarga', '$jenis_kelamin', '$tempat_lahir', '$pekerjaan', '$agama', '$pendidikan', '$tanggal_lahir')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

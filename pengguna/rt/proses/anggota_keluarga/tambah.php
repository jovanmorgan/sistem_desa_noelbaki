<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lengkap = $_POST['nama_lengkap'];
$id_rt = $_POST['id_rt'];
$id_kepala_keluarga = $_POST['id_kepala_keluarga'];
$nik_anggota_keluarga = $_POST['nik_anggota_keluarga'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$pekerjaan = $_POST['pekerjaan'];
$agama = $_POST['agama'];
$pendidikan = $_POST['pendidikan'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($id_rt) || empty($id_kepala_keluarga) || empty($nik_anggota_keluarga) || empty($jenis_kelamin) || empty($tempat_lahir) || empty($pekerjaan) || empty($agama) || empty($pendidikan) || empty($tanggal_lahir)) {
    echo "data_tidak_lengkap";
    exit();
}

// vadisai nik_anggota_keluarga sudah di gunakan
$check_query = "SELECT * FROM anggota_keluarga WHERE nik_anggota_keluarga = '$nik_anggota_keluarga'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "nkk_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// nik_anggota_keluarga wajib 16 digit
if (strlen($nik_anggota_keluarga) != 16) {
    echo "nkk_wajib_16_digit";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO anggota_keluarga (nama_lengkap, id_rt, id_kepala_keluarga, nik_anggota_keluarga, jenis_kelamin, tempat_lahir, pekerjaan, agama, pendidikan, tanggal_lahir)
        VALUES ('$nama_lengkap', '$id_rt', '$id_kepala_keluarga', '$nik_anggota_keluarga', '$jenis_kelamin', '$tempat_lahir', '$pekerjaan', '$agama', '$pendidikan', '$tanggal_lahir')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

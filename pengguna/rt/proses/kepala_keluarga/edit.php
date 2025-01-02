<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kepala_keluarga = $_POST['id_kepala_keluarga']; // Pastikan ID diterima untuk identifikasi data
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
if (empty($id_kepala_keluarga) || empty($nama_lengkap) || empty($id_rt) || empty($nomor_induk_kartu_keluarga) || empty($nik_kepala_keluarga) || empty($jenis_kelamin) || empty($tempat_lahir) || empty($pekerjaan) || empty($agama) || empty($pendidikan) || empty($tanggal_lahir)) {
    echo "data_tidak_lengkap";
    exit();
}

// Validasi nomor_induk_kartu_keluarga sudah digunakan oleh data lain
$check_query = "SELECT * FROM kepala_keluarga WHERE nomor_induk_kartu_keluarga = '$nomor_induk_kartu_keluarga' AND id_kepala_keluarga != '$id_kepala_keluarga'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "nikk_sudah_ada";
    exit();
}

// nomor_induk_kartu_keluarga wajib 16 digit
if (strlen($nomor_induk_kartu_keluarga) != 16) {
    echo "nikk_wajib_16_digit";
    exit();
}

// Validasi nik_kepala_keluarga sudah digunakan oleh data lain
$check_query = "SELECT * FROM kepala_keluarga WHERE nik_kepala_keluarga = '$nik_kepala_keluarga' AND id_kepala_keluarga != '$id_kepala_keluarga'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "nkk_sudah_ada";
    exit();
}

// nik_kepala_keluarga wajib 16 digit
if (strlen($nik_kepala_keluarga) != 16) {
    echo "nkk_wajib_16_digit";
    exit();
}

// Buat query SQL untuk mengupdate data masyarakat di dalam database
$query = "UPDATE kepala_keluarga SET 
            nama_lengkap = '$nama_lengkap',
            id_rt = '$id_rt',
            nomor_induk_kartu_keluarga = '$nomor_induk_kartu_keluarga',
            nik_kepala_keluarga = '$nik_kepala_keluarga',
            jenis_kelamin = '$jenis_kelamin',
            tempat_lahir = '$tempat_lahir',
            pekerjaan = '$pekerjaan',
            agama = '$agama',
            pendidikan = '$pendidikan',
            tanggal_lahir = '$tanggal_lahir'
          WHERE id_kepala_keluarga = '$id_kepala_keluarga'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

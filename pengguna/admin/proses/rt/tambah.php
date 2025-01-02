<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_rt = $_POST['nama_rt'];
$nama_lengkap = $_POST['nama_lengkap'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$username = $_POST['username'];
$password = $_POST['password'];
$alamat = $_POST['alamat'];
$jabatan = $_POST['jabatan'];

// Lakukan validasi data
if (empty($nama_rt) || empty($nama_lengkap) || empty($jenis_kelamin) || empty($username) || empty($password) || empty($alamat) || empty($jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Cek apakah username sudah ada di database
$check_query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_rt = "SELECT * FROM rt WHERE username = '$username'";
$result_rt = mysqli_query($koneksi, $check_query_rt);
if (mysqli_num_rows($result_rt) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_pimpinan = "SELECT * FROM pimpinan WHERE username = '$username'";
$result_pimpinan = mysqli_query($koneksi, $check_query_pimpinan);
if (mysqli_num_rows($result_pimpinan) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

$check_query_nama_rt = "SELECT * FROM rt WHERE nama_rt = '$nama_rt'";
$result_nama_rt = mysqli_query($koneksi, $check_query_nama_rt);
if (mysqli_num_rows($result_nama_rt) > 0) {
    echo "data_nama_rt_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon "error_password_length" jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon "error_password_strength" jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO rt (nama_rt, nama_lengkap, jenis_kelamin, username, password, alamat, jabatan)
        VALUES ('$nama_rt', '$nama_lengkap', '$jenis_kelamin', '$username', '$password', '$alamat', '$jabatan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);

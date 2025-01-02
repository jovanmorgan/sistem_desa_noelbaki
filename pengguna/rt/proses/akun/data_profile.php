<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Cek apakah terdapat data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_rt = $_POST['id_rt'];
    $nama_rt = $_POST['nama_rt'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];

    // Lakukan validasi data
    if (empty($nama_lengkap) || empty($password)) {
        echo "data tidak lengkap";
        exit();
    }

    // Cek apakah username sudah ada di database
    $check_query = "SELECT * FROM rt WHERE username = '$username' AND id_rt != '$id_rt'";
    $result = mysqli_query($koneksi, $check_query);
    if (mysqli_num_rows(result: $result) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }

    // Cek apakah username sudah ada di database
    $check_query_pimpinan = "SELECT * FROM pimpinan WHERE username = '$username'";
    $result_pimpinan = mysqli_query($koneksi, $check_query_pimpinan);
    if (mysqli_num_rows($result_pimpinan) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }

    // Cek apakah username sudah ada di database
    $check_query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $result_admin = mysqli_query($koneksi, $check_query_admin);
    if (mysqli_num_rows($result_admin) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }

    $check_query_nama_rt = "SELECT * FROM rt WHERE nama_rt = '$nama_rt'";
    $result_nama_rt = mysqli_query($koneksi, $check_query_nama_rt);
    if (mysqli_num_rows($result_nama_rt) > 0) {
        echo "error_username_exists"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
        exit();
    }

    // Query SQL untuk update data foto profile
    $query = "UPDATE rt SET password='$password', nama_rt='$nama_rt', nama_lengkap='$nama_lengkap', username='$username', jenis_kelamin='$jenis_kelamin', alamat='$alamat', jabatan='$jabatan' WHERE id_rt='$id_rt'";

    // Lakukan proses update data foto profile di database
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "success";
        exit();
    } else {
        // Jika terjadi kesalahan saat melakukan proses update, tampilkan pesan kesalahan
        echo "Gagal melakukan proses update data foto profile: " . mysqli_error($koneksi);
    }
} else {
    // Jika metode request bukan POST, berikan respons yang sesuai
    echo "Invalid request method";
    exit();
}

// Tutup koneksi ke database
mysqli_close($koneksi);

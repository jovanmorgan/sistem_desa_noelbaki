<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kontak = 1; // ID tetap 1 sesuai kebutuhan
$nomor_telpon = $_POST['nomor_telpon'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];

// Lakukan validasi data
if (empty($nomor_telpon) || empty($email) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Periksa apakah data dengan id_kontak sudah ada
$query_check = "SELECT id_kontak FROM kontak WHERE id_kontak = '$id_kontak'";
$result_check = mysqli_query($koneksi, $query_check);

// Jika data ada, lakukan update
if (mysqli_num_rows($result_check) > 0) {
    $query_update = "UPDATE kontak 
                     SET nomor_telpon = '$nomor_telpon', email = '$email', alamat = '$alamat' 
                     WHERE id_kontak = '$id_kontak'";
    if (mysqli_query($koneksi, $query_update)) {
        echo "data_diperbarui";
    } else {
        echo "error";
    }
} else {
    // Jika data tidak ada, lakukan insert
    $query_insert = "INSERT INTO kontak (id_kontak, nomor_telpon, email, alamat) 
                     VALUES ('$id_kontak', '$nomor_telpon', '$email', '$alamat')";
    if (mysqli_query($koneksi, $query_insert)) {
        echo "data_ditambahkan";
    } else {
        echo "error";
    }
}

// Tutup koneksi ke database
mysqli_close($koneksi);

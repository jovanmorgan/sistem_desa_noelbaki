<?php
// Pastikan Anda sudah menghubungkan ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $judul = $_POST['judul'];
    $waktu = $_POST['waktu'];
    $isi_pengumuman = $_POST['isi_pengumuman'];
    $jenis_pengumuman = $_POST['jenis_pengumuman'];
    $pengumuman_lainnya = $_POST['pengumuman_lainnya'];

    // Cek apakah jenis_pengumuman = "Pengumuman Lainnya"
    if ($jenis_pengumuman == 'Pengumuman Lainnya' && !empty($pengumuman_lainnya)) {
        $jenis_pengumuman = $pengumuman_lainnya;
    }

    // Memeriksa apakah semua data telah diisi
    if (empty($judul) || empty($waktu) || empty($isi_pengumuman) || empty($jenis_pengumuman)) {
        echo 'data_tidak_lengkap';
        exit;
    }

    // Memeriksa apakah file foto diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

        // Memeriksa ekstensi file
        if (in_array($file_ext, $allowed_extensions)) {
            // Membuat nama unik untuk file yang akan diunggah
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = '../../../../assets/img/pengumuman/'; // Direktori penyimpanan
            $upload_path = $upload_dir . $new_file_name;

            // Memindahkan file yang diunggah
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Menyimpan data ke database
                $query = "INSERT INTO pengumuman (judul, waktu, isi_pengumuman, jenis_pengumuman, foto) 
                          VALUES ('$judul', '$waktu', '$isi_pengumuman', '$jenis_pengumuman', '$new_file_name')";
                if (mysqli_query($koneksi, $query)) {
                    echo 'success';
                } else {
                    echo 'database_error';
                }
            } else {
                echo 'upload_failed';
            }
        } else {
            echo 'invalid_file_type';
        }
    } else {
        // Jika tidak ada file diunggah, tetap simpan data tanpa foto
        $query = "INSERT INTO pengumuman (judul, waktu, isi_pengumuman, jenis_pengumuman) 
                  VALUES ('$judul', '$waktu', '$isi_pengumuman', '$jenis_pengumuman')";
        if (mysqli_query($koneksi, $query)) {
            echo 'success';
        } else {
            echo 'database_error';
        }
    }
} else {
    echo 'invalid_request';
}

<?php
// Pastikan Anda sudah menghubungkan ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $id_kkm = $_POST['id_kkm'];
    $id_rt = $_POST['id_rt'];
    $id_kepala_keluarga = $_POST['id_kepala_keluarga'];
    $pemasukan_perbulan = $_POST['pemasukan_perbulan'];

    // Memeriksa apakah semua data telah diisi
    if (empty($id_kkm) || empty($id_rt) || empty($id_kepala_keluarga) || empty($pemasukan_perbulan)) {
        echo 'data_tidak_lengkap';
        exit;
    }

    // Cek apakah id_kepala_keluarga sudah ada di database
    $check_query_keluarga_kurang_mampu = "SELECT * FROM keluarga_kurang_mampu WHERE id_kepala_keluarga = '$id_kepala_keluarga' AND id_kkm != '$id_kkm'";
    $result_keluarga_kurang_mampu = mysqli_query($koneksi, $check_query_keluarga_kurang_mampu);
    if (
        mysqli_num_rows($result_keluarga_kurang_mampu) > 0
    ) {
        echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
        exit();
    }


    // Direktori penyimpanan gambar
    $upload_dir = '../../../../assets/img-umum/konten/';
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

    // Fungsi untuk memproses upload file
    function handle_upload($field_name, $upload_dir, $allowed_extensions)
    {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == 0) {
            $file_name = $_FILES[$field_name]['name'];
            $file_tmp = $_FILES[$field_name]['tmp_name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if (in_array($file_ext, $allowed_extensions)) {
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    return $new_file_name;
                } else {
                    return 'upload_failed';
                }
            } else {
                return 'invalid_file_type';
            }
        }
        return null;
    }

    // Gambar yang akan diupload
    $foto_rumah = handle_upload('foto_rumah', $upload_dir, $allowed_extensions);
    $foto_keluarga = handle_upload('foto_keluarga', $upload_dir, $allowed_extensions);

    // Memeriksa jika ada kesalahan pada upload file
    if ($foto_rumah === 'upload_failed' || $foto_keluarga === 'upload_failed') {
        echo 'upload_failed';
        exit;
    }

    if ($foto_rumah === 'invalid_file_type' || $foto_keluarga === 'invalid_file_type') {
        echo 'invalid_file_type';
        exit;
    }

    // Update data ke database
    $query = "UPDATE keluarga_kurang_mampu SET 
              id_rt = '$id_rt',
              id_kepala_keluarga = '$id_kepala_keluarga',
              pemasukan_perbulan = '$pemasukan_perbulan'";

    // Menambahkan bagian untuk update foto jika ada file baru yang diupload
    if ($foto_rumah) {
        $query .= ", foto_rumah = '$foto_rumah'";
    }
    if ($foto_keluarga) {
        $query .= ", foto_keluarga = '$foto_keluarga'";
    }

    $query .= " WHERE id_kkm = '$id_kkm'";

    if (mysqli_query($koneksi, $query)) {
        echo 'success';
    } else {
        echo 'database_error';
    }
} else {
    echo 'invalid_request';
}

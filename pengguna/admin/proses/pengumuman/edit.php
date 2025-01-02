<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengumuman = $_POST['id_pengumuman'];
    $judul = $_POST['judul'];
    $waktu = $_POST['waktu'];
    $isi_pengumuman = $_POST['isi_pengumuman'];
    $jenis_pengumuman = $_POST['jenis_pengumuman'];
    $pengumuman_lainnya = $_POST['pengumuman_lainnya'];

    // Cek apakah jenis_pengumuman = "Pengumuman Lainnya"
    if ($jenis_pengumuman == 'Pengumuman Lainnya' && !empty($pengumuman_lainnya)) {
        $jenis_pengumuman = $pengumuman_lainnya;
    }

    // Validasi input
    if (empty($judul) || empty($waktu) || empty($isi_pengumuman) || empty($jenis_pengumuman)) {
        echo 'data_tidak_lengkap';
        exit;
    }

    // Handling file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

        // Memeriksa ekstensi file
        if (in_array($file_ext, $allowed_extensions)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = '../../../../assets/img/pengumuman/'; // Direktori penyimpanan
            $upload_path = $upload_dir . $new_file_name;

            // Memindahkan file yang diunggah
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update dengan file foto baru
                $query = "UPDATE pengumuman SET judul='$judul', waktu='$waktu', isi_pengumuman='$isi_pengumuman', jenis_pengumuman='$jenis_pengumuman', foto='$new_file_name' WHERE id_pengumuman='$id_pengumuman'";
            } else {
                echo 'upload_failed';
                exit;
            }
        } else {
            echo 'invalid_file_type';
            exit;
        }
    } else {
        // Update tanpa mengganti file foto
        $query = "UPDATE pengumuman SET judul='$judul', waktu='$waktu', isi_pengumuman='$isi_pengumuman', jenis_pengumuman='$jenis_pengumuman' WHERE id_pengumuman='$id_pengumuman'";
    }

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo 'success';
    } else {
        echo 'database_error';
    }
} else {
    echo 'invalid_request';
}
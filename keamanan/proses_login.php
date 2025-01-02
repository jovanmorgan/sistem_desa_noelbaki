<?php
include 'koneksi.php';

function checkpenggunahType($username)
{
    global $koneksi;
    $query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $query_rt = "SELECT * FROM rt WHERE username = '$username'";
    $query_pimpinan = "SELECT * FROM pimpinan WHERE username = '$username'";

    $result_admin = mysqli_query($koneksi, $query_admin);
    $result_rt = mysqli_query($koneksi, $query_rt);
    $result_pimpinan = mysqli_query($koneksi, $query_pimpinan);

    if (mysqli_num_rows($result_admin) > 0) {
        return "admin";
    } elseif (mysqli_num_rows($result_rt) > 0) {
        return "rt";
    } elseif (mysqli_num_rows($result_pimpinan) > 0) {
        return "pimpinan";
    } else {
        return "not_found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($username) && empty($password)) {
        echo "tidak_ada_data";
        exit();
    }
    if (empty($username)) {
        echo "username_tidak_ada";
        exit();
    }

    if (empty($password)) {
        echo "password_tidak_ada";
        exit();
    }


    $penggunahType = checkpenggunahType($username);
    if ($penggunahType !== "not_found") {
        $query_penggunah = "SELECT * FROM $penggunahType WHERE username = '$username'";
        $result_penggunah = mysqli_query($koneksi, $query_penggunah);

        if (mysqli_num_rows($result_penggunah) > 0) {
            $row = mysqli_fetch_assoc($result_penggunah);
            $hashed_password = $row['password'];

            if ($password === $hashed_password) {

                // Process login for other penggunah types
                session_start();
                $_SESSION['username'] = $username;

                switch ($penggunahType) {
                    case "admin":
                        $_SESSION['id_admin'] = $row['id_admin'];
                        break;
                    case "rt":
                        $_SESSION['id_rt'] = $row['id_rt'];
                        $id_rt = $row['id_rt'];
                        break;
                    case "pimpinan":
                        $_SESSION['id_pimpinan'] = $row['id_pimpinan'];
                        break;
                    default:
                        break;
                }

                // Success response
                switch ($penggunahType) {
                    case "admin":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/admin/";
                        break;
                    case "rt":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/rt/";
                        break;
                    case "pimpinan":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/pimpinan/";
                        break;
                    default:
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../berlangganan/login";
                        break;
                }
            } else {
                echo "error_password";
            }
        } else {
            echo "error_username";
        }
    } else {
        echo "error_username";
    }
}

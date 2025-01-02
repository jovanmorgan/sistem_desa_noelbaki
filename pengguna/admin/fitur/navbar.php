    <?php
    // Lakukan koneksi ke database
    include '../../keamanan/koneksi.php';

    // Periksa apakah session id_admin telah diset
    if (isset($_SESSION['id_admin'])) {
        $id_admin = $_SESSION['id_admin'];

        // Query SQL untuk mengambil data admin berdasarkan id_admin dari session
        $query = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
        $result = mysqli_query($koneksi, $query);

        // Periksa apakah query berhasil dieksekusi
        if ($result) {
            // Periksa apakah terdapat data admin
            if (mysqli_num_rows($result) > 0) {
                // Ambil data admin sebagai array asosiatif
                $admin = mysqli_fetch_assoc($result);
    ?>
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
        data-scroll="false">
        <div class="container-fluid py-1 px-3">

            <?php include "fitur/papan_halaman.php" ?>

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control input-sercing" name="query"
                                placeholder="Cari Halaman...">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-white font-weight-bold px-0" id="profileDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i
                                class="ni ni-single-02 text-white p-2 bg-gradient-warning border-radius-md border shadow"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                            aria-labelledby="profileDropdown">
                            <!-- Konten Pengguna -->
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="profile">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <?php if (!empty($admin['fp'])): ?>
                                            <img src="../../assets/img-umum/foto_profile/<?php echo $admin['fp']; ?>"
                                                class="avatar avatar-sm me-3">
                                            <?php else: ?>
                                            <img src="../../assets/img-umum/umum/no_image.jpg"
                                                class="avatar avatar-sm me-3">
                                            <?php endif; ?>

                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1 text-black">
                                                Hay, <span
                                                    class="font-weight-bold text-black"><?php echo $admin['nama_lengkap']; ?></span>
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-circle text-success me-1"></i>
                                                Aktif sekarang..
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <!-- Divider -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Logout -->
                            <li>
                                <a class="dropdown-item border-radius-md d-flex align-items-center text-danger"
                                    href="log_out">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">

                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <?php
            } else {
                // Jika tidak ada data admin
                echo "Tidak ada data admin.";
            }
        } else {
            // Jika query tidak berhasil dieksekusi
            echo "Gagal mengambil data admin: " . mysqli_error($koneksi);
        }
    } else {
        // Jika session id_admin tidak diset
        echo "Session id_admin tidak tersedia.";
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
    ?>
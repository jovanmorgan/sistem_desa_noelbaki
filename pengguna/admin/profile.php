<?php include 'fitur/penggunah.php'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include 'fitur/head.php'; ?>

<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-gradient-warning position-absolute w-100"></div>

    <!-- sidebar -->
    <?php include 'fitur/sidebar.php'; ?>

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
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
                                        <a href="javascript:;" class="nav-link text-white font-weight-bold px-0"
                                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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

                    <!-- End Navbar -->

                    <div class="container-fluid py-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-profile">
                                    <div id="random-bg" class="card-img-top"></div>
                                    <div class="row justify-content-center">
                                        <div class="col-4 col-lg-4 order-lg-2">
                                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                                <a href="javascript:;"
                                                    onclick="document.getElementById('editFotoProfile').click()"></a>
                                                <a href="javascript:void(0)"
                                                    onclick="document.getElementById('editFotoProfile').click()">
                                                    <?php if (!empty($admin['fp'])): ?>
                                                        <img src="../../assets/img-umum/foto_profile/<?php echo $admin['fp']; ?>"
                                                            class="rounded-circle img-fluid border border-2 border-white">
                                                    <?php else: ?>
                                                        <img src="../../assets/img-umum/umum/no_image.jpg"
                                                            class="rounded-circle img-fluid border border-2 border-white">
                                                    <?php endif; ?>
                                                </a>
                                                <!-- Input file tersembunyi untuk memilih gambar -->
                                                <input type="file" class="d-none" id="editFotoProfile" name="editFotoProfile"
                                                    accept="image/*" onchange="previewAndUpdateProfile(this)">

                                                <!-- Modal -->
                                                <div class="modal fade" id="editFotoProfileModal" tabindex="-1"
                                                    aria-labelledby="editFotoProfileModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editFotoProfileModalLabel">Edit
                                                                    Foto Profile
                                                                </h5>
                                                                <button type="button" class="btn-close text-dark"
                                                                    id="closeTambahModal" data-bs-dismiss="modal"
                                                                    aria-label="Close"><i class="fas fa-times"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="gambar">
                                                                    <img id="editFotoProfilePreview" src="#"
                                                                        alt="Preview Foto Profile" class="img-fluid">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                                    onclick="location.reload();">Close</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    id="btnSaveProfile">Simpan Perubahan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <style>
                                                    .profile-picturess .gbrr {
                                                        border-radius: 50%;
                                                        /* Sesuaikan dengan ukuran yang diinginkan */
                                                        object-fit: cover;
                                                        /* Memastikan gambar mengisi area tanpa distorsi */
                                                    }

                                                    .gambar {
                                                        max-width: 500px;
                                                        height: 500px;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="text-center mt-4">
                                            <h5 class="mb-3"><?php echo $admin['nama_lengkap']; ?></h5>
                                            <table class="table table-borderless text-start">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted"><i class="fa fa-user"></i></th>
                                                        <td><?php echo $admin['username'] ? $admin['username'] : '<p class="text-danger">~Belum diisi~</p>'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted"><i class="fa fa-lock"></i></th>
                                                        <td><?php echo $admin['password'] ? $admin['password'] : '<p class="text-danger">~Belum diisi~</p>'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted"><i class="fa fa-male"></i>/<i
                                                                class="fa fa-female"></i></th>
                                                        <td><?php echo $admin['jenis_kelamin'] ? $admin['jenis_kelamin'] : '<p class="text-danger">~Belum diisi~</p>'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted"><i class="fa fa-phone"></i></th>
                                                        <td><?php echo $admin['no_telpon'] ? $admin['no_telpon'] : '<p class="text-danger">~Belum diisi~</p>'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted"><i class="fa fa-briefcase"></i></th>
                                                        <td><?php echo $admin['jabatan'] ? $admin['jabatan'] : '<p class="text-danger">~Belum diisi~</p>'; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                /* Penyesuaian gaya tabel */
                                .table-borderless th {
                                    width: 20%;
                                    font-weight: 100;
                                }

                                .table-borderless td {
                                    color: #555;
                                }

                                .card-body h5 {
                                    color: #333;
                                    font-weight: bold;
                                }

                                /* Styling untuk gambar background */
                                #random-bg {
                                    height: 200px;
                                    background-image: url('../../assets/img-umum/umum/bg-umum.jpg');
                                    /* Fallback awal */
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center;
                                    border-radius: 0.75rem 0.75rem 0 0;
                                }
                            </style>

                            <script>
                                // URL API dengan resolusi tinggi
                                const randomImageAPI = 'https://picsum.photos/1000/400'; // Gambar resolusi tinggi
                                const fallbackImage = '../../assets/img-umum/umum/bg-umum.jpg'; // Gambar cadangan

                                // Fungsi untuk mencoba mengganti gambar background
                                function loadImage() {
                                    const randomBg = document.getElementById('random-bg');

                                    // Set gambar fallback terlebih dahulu
                                    randomBg.style.backgroundImage = `url('${fallbackImage}')`;

                                    // Coba memuat gambar dari API
                                    fetch(randomImageAPI)
                                        .then(response => {
                                            if (response.ok) {
                                                // Konversi gambar API ke URL
                                                return response.url;
                                            } else {
                                                throw new Error('Gambar API tidak dapat dimuat');
                                            }
                                        })
                                        .then(apiImageUrl => {
                                            // Jika gambar berhasil diambil, ubah background
                                            randomBg.style.backgroundImage = `url('${apiImageUrl}')`;
                                        })
                                        .catch(error => {
                                            console.error('Gagal memuat gambar dari API, menggunakan fallback:', error);
                                        });
                                }

                                // Panggil fungsi saat halaman dimuat
                                loadImage();
                            </script>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0">Edit Profile</p>
                                        </div>
                                    </div>
                                    <form id="editProfileForm">
                                        <div class="card-body">
                                            <div class="row">
                                                <input type="text" name="id_admin" id="id_admin"
                                                    value="<?php echo $admin['id_admin']; ?>" hidden>
                                                <!-- Nama Lengkap -->
                                                <div class="mb-3">
                                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                                                            class="form-control" value="<?php echo $admin['nama_lengkap']; ?>"
                                                            placeholder="Masukkan nama lengkap" required>
                                                    </div>
                                                </div>

                                                <!-- Jenis Kelamin -->
                                                <div class="mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                        <!-- select option nya jika sama dengan <?php echo $admin['jenis_kelamin']; ?>  -->
                                                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin"
                                                            required>
                                                            <option value="" disabled selected>Pilih jenis kelamin</option>
                                                            <option value="pria"
                                                                <?php echo $admin['jenis_kelamin']  == 'pria' ? 'selected' : ''; ?>>
                                                                Pria
                                                            </option>
                                                            <option value="wanita"
                                                                <?php echo $admin['jenis_kelamin']  == 'wanita' ? 'selected' : ''; ?>>
                                                                Wanita
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Username -->
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                                        <input type="text" id="username" name="username" class="form-control"
                                                            placeholder="Masukkan username"
                                                            value="<?php echo $admin['username']; ?>" required>
                                                    </div>
                                                </div>

                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                        <input type="text" id="password" name="password" class="form-control"
                                                            placeholder="Masukkan password"
                                                            value="<?php echo $admin['password']; ?>" required>
                                                    </div>
                                                </div>

                                                <!-- nomor telpon -->
                                                <div class="mb-3">
                                                    <label for="no_telpon" class="form-label">Nomor Telpon</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                        <input type="number" min="0" id="no_telpon" name="no_telpon"
                                                            class="form-control" placeholder="Masukkan nomor telpon"
                                                            value="<?php echo $admin['no_telpon']; ?>" required>
                                                    </div>
                                                </div>

                                                <!-- jabatan -->
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                        <select class="form-select" name="jabatan" id="jabatan" required>
                                                            <option value="" disabled selected>Pilih Jabatan</option>
                                                            <option value="Kepala Desa"
                                                                <?php echo $admin['jabatan'] == 'Kepala Desa' ? 'selected' : ''; ?>>
                                                                Kepala Desa</option>
                                                            <option value="Sekertaris"
                                                                <?php echo $admin['jabatan'] == 'Sekertaris' ? 'selected' : ''; ?>>
                                                                Sekertaris</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="horizontal dark">
                                        <div class="card-footer">
                                            <!-- buat tombol di kanan -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

                        </div>
                        <!-- footer -->
                        <?php include_once 'fitur/footer.php'; ?>
                    </div>
    </main>

    <!-- akhir pop up -->

    <!-- Loading Element -->
    <div class="loading" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- CSS for Loading Spinner -->
    <style>
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- <script src="../../assets/js/sweetalert2.all.min.js"></script> -->
    <script>
        // Variabel global untuk menyimpan instance Cropper
        var cropper;

        const loding = document.querySelector('.loading');

        // Fungsi untuk menampilkan gambar yang dipilih dan menampilkan modal
        function previewAndUpdateProfile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#editFotoProfilePreview').attr('src', e.target.result);
                    $('#editFotoProfileModal').modal('show');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Fungsi untuk memotong gambar dan menyimpannya
        function cropImage() {
            var croppedCanvas = cropper.getCroppedCanvas({
                width: 200, // Tentukan lebar gambar yang diinginkan
                height: 200 // Tentukan tinggi gambar yang diinginkan
            });
            var croppedDataUrl = croppedCanvas.toDataURL();

            // Tampilkan elemen .loading sebelum mengirimkan permintaan AJAX
            loding.style.display = 'flex';

            // Simpan data gambar ke server menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: 'proses/akun/foto_profile.php',
                data: {
                    imageBase64: croppedDataUrl
                },
                success: function(response) {

                    // Sembunyikan elemen .loading setelah permintaan AJAX selesai
                    loding.style.display = 'none';

                    // Tampilkan sweet alert dengan pesan respon tanpa tombol OK dan hilang dalam 1,5 detik
                    swal({
                        title: "Sukses!",
                        text: "Foto profile berhasil diperbarui.",
                        icon: "success",
                        timer: 1500,
                        buttons: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Tampilkan sweet alert dengan pesan error
                    swal("Error!", xhr.responseText, "error");
                }
            });

            // Sembunyikan modal pemotongan gambar
            $('#editFotoProfileModal').modal('hide');
        }

        $(document).ready(function() {
            $('#editFotoProfileModal').on('shown.bs.modal', function() {
                // Inisialisasi Cropper setelah modal ditampilkan
                var containerWidth = $('.gambar').width();
                var containerHeight = $('.gambar').height();
                cropper = new Cropper($('#editFotoProfilePreview')[0], {
                    aspectRatio: 1, // 1:1 aspect ratio
                    viewMode: 1, // Crop mode
                    minContainerWidth: containerWidth, // Set minimum container width to match image container width
                    minContainerHeight: containerHeight, // Set minimum container height to match image container height
                });
            });

            $('#btnSaveProfile').on('click', function() {
                cropImage();
            });

            $('#editFotoProfileModal').on('hidden.bs.modal', function() {
                // Hapus cropper ketika modal ditutup
                if (cropper) {
                    cropper.destroy();
                }
            });
        });

        $(document).ready(function() {
            $('#editProfileForm').on('submit', function(event) {
                event.preventDefault(); // Mencegah perilaku default form submit

                // Tangkap data formulir
                var formData = $('#editProfileForm').serialize();

                // Tampilkan elemen .loading sebelum mengirimkan permintaan AJAX
                loding.style.display = 'flex';

                $.ajax({
                    type: 'POST',
                    url: 'proses/akun/data_profile.php',
                    data: formData, // Kirim data formulir yang telah ditangkap
                    success: function(response) {

                        // Sembunyikan elemen .loading setelah permintaan AJAX selesai
                        loding.style.display = 'none';

                        // Periksa apakah respons adalah 'success'
                        if (response === 'success') {
                            // Tampilkan sweet alert dengan pesan sukses tanpa tombol OK dan hilang dalam 1,5 detik
                            swal({
                                title: "Sukses!",
                                text: "Data diri berhasil diperbarui",
                                icon: "success",
                                timer: 1500,
                                buttons: false
                            }).then(() => {
                                location
                                    .reload(); // Muat ulang halaman setelah SweetAlert hilang
                            });
                        } else if (response === 'error_username_exists') {
                            // Jika Nomor Pengguna sudah ada, tampilkan pesan khusus
                            swal({
                                title: "Nomor Pengguna Sudah Ada!",
                                text: "Nomor Pengguna yang Anda masukkan sudah terdaftar",
                                icon: "info",
                                timer: 1500,
                                buttons: false
                            });
                        } else {
                            // Jika respons adalah sesuatu yang tidak diharapkan, tampilkan pesan error
                            swal({
                                title: "Error!",
                                text: response,
                                icon: "error",
                                timer: 1500,
                                buttons: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan sweet alert dengan pesan error
                        swal("Error!", xhr.responseText, "error");
                    }
                });
            });
        });
    </script>
    <!--   Core JS Files   -->
    <script src="../../assets/js/core/jquery.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets/js/core/popper.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets/js/core/bootstrap.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js?v=<?= time(); ?>"></script>

</body>

</html>

</html>
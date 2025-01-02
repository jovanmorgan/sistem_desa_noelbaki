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
        <?php include 'fitur/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">

                <div class="col-12">
                    <div class="card mb-4">
                        <!-- Konten Utama -->
                        <div class="card-body px-3 pt-3 pb-2">
                            <!-- Header dengan kata sambutan -->
                            <div class="card-header pb-0 text-center">
                                <h4>Selamat Datang!</h4>
                                <p class="text-sm">Berikut adalah tabel <?= htmlspecialchars($page_title) ?> data yang
                                    dapat Anda kelola. Gunakan fitur
                                    pencarian untuk menemukan data dengan cepat, atau tambahkan data baru menggunakan
                                    tombol di bawah.
                                </p>
                            </div>

                            <!-- Tombol Tambah dan Ekspor -->
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-success me-2" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Perbarui Data</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="load_data">
                    <!-- Contact Start -->
                    <div class="container-xxl py-5">
                        <div class="container">
                            <div class="row g-4">

                                <?php
                                include '../../keamanan/koneksi.php';

                                // Ambil data kontak dengan id_kontak = 1
                                $id_kontak = 1;
                                $query = "SELECT * FROM kontak WHERE id_kontak = '$id_kontak'";
                                $result = mysqli_query($koneksi, $query);

                                // Jika data ditemukan, simpan nilai ke dalam variabel
                                if ($row = mysqli_fetch_assoc($result)) {
                                    $alamat = $row['alamat'];
                                    $nomor_telpon = $row['nomor_telpon'];
                                    $email = $row['email'];
                                } else {
                                    // Default nilai jika data tidak ditemukan
                                    $alamat = "Alamat belum tersedia";
                                    $nomor_telpon = "Nomor belum tersedia";
                                    $email = "Email belum tersedia";
                                }

                                // Tutup koneksi
                                mysqli_close($koneksi);
                                ?>

                                <!-- Address Section -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                                        <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fa fa-map-marker-alt text-primary fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-1">Alamat Gereja</p>
                                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($alamat); ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Section -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                                        <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fa fa-phone text-primary fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-1">Hubungi Kami</p>
                                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($nomor_telpon); ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Section -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                                        <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 60px; height: 60px;">
                                            <i class="fa fa-envelope-open text-primary fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-1">Email Kami</p>
                                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($email); ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Map Section -->
                                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="h-100" style="min-height: 400px;">
                                        <iframe class="rounded shadow-sm w-100 h-100"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.306918229313!2d123.7071739!3d-10.1286378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c56817ea92e5767%3A0x98b915bd574e1973!2sKantor%20DESA%20NOELBAKI!5e0!3m2!1sen!2sid!4v1702828290123!5m2!1sen!2sid"
                                            frameborder="0" allowfullscreen="" aria-hidden="false"
                                            tabindex="0"></iframe>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Contact End -->
                </div>
            </div>
            <!-- footer -->
            <?php include_once 'fitur/footer.php'; ?>
        </div>
    </main>

    <!-- awal pop Up -->

    <div class="modal-pop-up" style="z-index: 100">
        <!-- Modal -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                            enctype="multipart/form-data">
                            <!-- Nomor Telepon -->
                            <div class="mb-3">
                                <label for="nomor_telpon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="number" min="0" id="nomor_telpon" name="nomor_telpon"
                                        class="form-control" value="<?= htmlspecialchars($nomor_telpon); ?>"
                                        placeholder="Masukkan Nomor Telepon" required>
                                </div>
                            </div>

                            <!-- Gmail -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope-open"></i></span>
                                    <input type="text" id="email" value="<?= htmlspecialchars($email); ?>" name="email"
                                        class="form-control" placeholder="Masukkan Email" required>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id=" alamat" name="alamat" rows="3"
                                        placeholder="Masukkan alamat"
                                        required><?= htmlspecialchars($alamat); ?></textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- akhir pop up -->

    <script>
        function openEditModal(id, nama_lengkap, jenis_kelamin, username, password, no_telpon, jabatan) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_lengkap').value = nama_lengkap;
            document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_password').value = password;
            document.getElementById('edit_no_telpon').value = no_telpon;
            document.getElementById('edit_jabatan').value = jabatan;
            editModal.show();
        }
    </script>

    <?php include_once 'fitur/js.php'; ?>
</body>

</html>

</html>
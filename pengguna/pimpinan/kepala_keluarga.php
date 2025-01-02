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

                            <form method="GET" action="">
                                <div class="input-group">
                                    <!-- Input pencarian -->
                                    <input type="text" class="form-control"
                                        placeholder="Cari Data <?= htmlspecialchars($page_title) ?>..." name="search"
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        style="height: 50px;">
                                    <!-- Tombol pencarian -->
                                    <button class="btn btn-outline-secondary" type="submit"
                                        style="height: 50px;">Cari</button>
                                </div>
                            </form>

                            <!-- Tombol Tambah dan Ekspor -->
                            <div class="d-flex justify-content-center mt-3">
                                <a class="btn btn-outline-primary" target="_blank"
                                    href="export/<?= htmlspecialchars($page_title_proses) ?>">Ekspor Data</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                include '../../keamanan/koneksi.php';

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;

                // Query untuk mendapatkan data kepala_keluarga dengan pencarian dan pagination
                $query = "
    SELECT 
        kk.id_kepala_keluarga,
        kk.id_rt,
        rt.nama_rt,
        kk.nama_lengkap,
        kk.nomor_induk_kartu_keluarga,
        kk.nik_kepala_keluarga,
        kk.jenis_kelamin,
        kk.tempat_lahir,
        kk.pekerjaan,
        kk.tanggal_lahir,
        kk.agama,
        kk.pendidikan
    FROM kepala_keluarga kk
    INNER JOIN rt ON kk.id_rt = rt.id_rt
    WHERE kk.nama_lengkap LIKE ? OR kk.nomor_induk_kartu_keluarga LIKE ? OR kk.nik_kepala_keluarga LIKE ? OR kk.jenis_kelamin LIKE ? 
    LIMIT ?, ?
";

                $stmt = $koneksi->prepare($query);
                $search_param = '%' . $search . '%';
                $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                $stmt->execute();
                $result = $stmt->get_result();

                // Hitung total halaman
                $total_query = "
    SELECT COUNT(*) as total 
    FROM kepala_keluarga kk
    INNER JOIN rt ON kk.id_rt = rt.id_rt
    WHERE kk.nama_lengkap LIKE ? OR kk.nomor_induk_kartu_keluarga LIKE ? OR kk.nik_kepala_keluarga LIKE ? OR kk.jenis_kelamin LIKE ? 
";
                $stmt_total = $koneksi->prepare($total_query);
                $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                $stmt_total->execute();
                $total_result = $stmt_total->get_result();
                $total_row = $total_result->fetch_assoc();
                $total_pages = ceil($total_row['total'] / $limit);
                ?>

                <div class="col-12" id="load_data">
                    <div class="card mb-4">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <?php if ($result->num_rows > 0): ?>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nomor</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                RT</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nomor Induk Kartu Keluarga</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nomor Induk Kependudukan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Lengkap</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tempat Lahir</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Lahir</th>
                                            <th en
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jenis Kelamin</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pekerjaan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Agama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pendidikan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $nomor = $offset + 1;
                                            while ($row = $result->fetch_assoc()) :
                                            ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo $nomor++; ?></span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">RT :
                                                    <?php echo htmlspecialchars($row['nama_rt']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nomor_induk_kartu_keluarga']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nik_kepala_keluarga']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['tempat_lahir']); ?></span>
                                            </td>
                                            <td class="align-middle text-center"><span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['jenis_kelamin']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['pekerjaan']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['agama']); ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['pendidikan']); ?></span>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan 🗂️.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card mb-4">
                        <!-- Konten Utama -->
                        <div class="card-body px-3 pt-3 pb-2">
                            <!-- Pagination -->
                            <nav>
                                <ul class="pagination justify-content-center ">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link text-white"
                                            href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
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
                        <button type="button" class="btn-close text-dark" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                            enctype="multipart/form-data">

                            <input type="hidden" name="id_rt" value="<?php echo $id_rt; ?>" id="id_rt">
                            <!-- Nomor Induk Kartu Keluarga -->
                            <div class="mb-3">
                                <label for="nomor_induk_kartu_keluarga" class="form-label">Nomor Induk Kartu
                                    Keluarga</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nomor_induk_kartu_keluarga" name="nomor_induk_kartu_keluarga"
                                        class="form-control" placeholder="Masukkan Nomor Induk Kartu Keluarga" required
                                        maxlength="16"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16);" />
                                </div>
                            </div>


                            <!-- Nomor Induk Kependudukan -->
                            <div class="mb-3">
                                <label for="nik_kepala_keluarga" class="form-label">Nomor Induk Kependudukan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nik_kepala_keluarga" name="nik_kepala_keluarga"
                                        class="form-control" placeholder="Masukkan Nomor Induk Kependudukan" required
                                        maxlength="16"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16);" />
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id="tempat_lahir" name="tempat_lahir" rows="3"
                                        placeholder="Masukkan tempat lahir" required></textarea>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih jenis kelamin</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan Terakhir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                                        <option value="" disabled selected>Pilih pekerjaan</option>
                                        <option value="pelajar">Pelajar</option>
                                        <option value="guru">Guru</option>
                                        <option value="arsitek">Arsitek</option>
                                        <option value="nelayan">Nelayan</option>
                                        <option value="perawat">Perawat</option>
                                        <option value="dokter">Dokter</option>
                                        <option value="bidan">Bidan</option>
                                        <option value="pemadam kebakaran">Pemadam Kebakaran</option>
                                        <option value="kondektur">Kondektur</option>
                                        <option value="pilot">Pilot</option>
                                        <option value="masinis">Masinis</option>
                                        <option value="wartawan">Wartawan</option>
                                        <option value="penulis">Penulis</option>
                                        <option value="insinyur mesin">Insinyur Mesin</option>
                                        <option value="ahli gizi">Ahli Gizi</option>
                                        <option value="pustakawan">Pustakawan</option>
                                        <option value="hakim">Hakim</option>
                                        <option value="notaris">Notaris</option>
                                        <option value="teller bank">Teller Bank</option>
                                        <option value="koki">Koki</option>
                                        <option value="artis">Artis</option>
                                        <option value="penerjemah">Penerjemah</option>
                                        <option value="tentara">Tentara</option>
                                        <option value="tukang cukur">Tukang Cukur</option>
                                        <option value="petani">Petani</option>
                                        <option value="akuntan">Akuntan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-cross"></i></span>
                                    <select class="form-select" name="agama" id="agama" required>
                                        <option value="" disabled selected>Pilih agama</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="konghucu">Konghucu</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pendidikan -->
                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <select class="form-select" name="pendidikan" id="pendidikan" required>
                                        <option value="" disabled selected>Pilih pendidikan</option>
                                        <option value="sd">SD</option>
                                        <option value="smp">SMP</option>
                                        <option value="sma">SMA</option>
                                        <option value="diploma">Diploma</option>
                                        <option value="sarjana">Sarjana</option>
                                        <option value="magister">Magister</option>
                                        <option value="doktor">Doktor</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
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


        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                        <button type="button" class="btn-close text-dark" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"> <i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" id="edit_id" name="id_kepala_keluarga">
                            <input type="hidden" name="id_rt" id="edit_id_rt">


                            <!-- Nomor Induk Kartu Keluarga -->
                            <div class="mb-3">
                                <label for="nomor_induk_kartu_keluarga" class="form-label">Nomor Induk Kartu
                                    Keluarga</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="edit_nomor_induk_kartu_keluarga"
                                        name="nomor_induk_kartu_keluarga" class="form-control"
                                        placeholder="Masukkan Nomor Induk Kartu Keluarga" required maxlength="16"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16);" />
                                </div>
                            </div>

                            <!-- Nomor Induk Kependudukan -->
                            <div class="mb-3">
                                <label for="nik_kepala_keluarga" class="form-label">Nomor Induk Kependudukan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="edit_nik_kepala_keluarga" name="nik_kepala_keluarga"
                                        class="form-control" placeholder="Masukkan Nomor Induk Kependudukan" required
                                        maxlength="16"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16);" />
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id="edit_tempat_lahir" name="tempat_lahir" rows="3"
                                        placeholder="Masukkan tempat lahir" required></textarea>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select class="form-select" name="jenis_kelamin" id="edit_jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih jenis kelamin</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan Terakhir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <select class="form-select" name="pekerjaan" id="edit_pekerjaan" required>
                                        <option value="" disabled selected>Pilih pekerjaan</option>
                                        <option value="pelajar">Pelajar</option>
                                        <option value="guru">Guru</option>
                                        <option value="arsitek">Arsitek</option>
                                        <option value="nelayan">Nelayan</option>
                                        <option value="perawat">Perawat</option>
                                        <option value="dokter">Dokter</option>
                                        <option value="bidan">Bidan</option>
                                        <option value="pemadam kebakaran">Pemadam Kebakaran</option>
                                        <option value="kondektur">Kondektur</option>
                                        <option value="pilot">Pilot</option>
                                        <option value="masinis">Masinis</option>
                                        <option value="wartawan">Wartawan</option>
                                        <option value="penulis">Penulis</option>
                                        <option value="insinyur mesin">Insinyur Mesin</option>
                                        <option value="ahli gizi">Ahli Gizi</option>
                                        <option value="pustakawan">Pustakawan</option>
                                        <option value="hakim">Hakim</option>
                                        <option value="notaris">Notaris</option>
                                        <option value="teller bank">Teller Bank</option>
                                        <option value="koki">Koki</option>
                                        <option value="artis">Artis</option>
                                        <option value="penerjemah">Penerjemah</option>
                                        <option value="tentara">Tentara</option>
                                        <option value="tukang cukur">Tukang Cukur</option>
                                        <option value="petani">Petani</option>
                                        <option value="akuntan">Akuntan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-cross"></i></span>
                                    <select class="form-select" name="agama" id="edit_agama" required>
                                        <option value="" disabled selected>Pilih agama</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="konghucu">Konghucu</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pendidikan -->
                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <select class="form-select" name="pendidikan" id="edit_pendidikan" required>
                                        <option value="" disabled selected>Pilih pendidikan</option>
                                        <option value="sd">SD</option>
                                        <option value="smp">SMP</option>
                                        <option value="sma">SMA</option>
                                        <option value="diploma">Diploma</option>
                                        <option value="sarjana">Sarjana</option>
                                        <option value="magister">Magister</option>
                                        <option value="doktor">Doktor</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
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
    function openEditModal(id, nama_lengkap, nomor_induk_kartu_keluarga, nik_kepala_keluarga, jenis_kelamin,
        tempat_lahir, pekerjaan, tanggal_lahir, agama, pendidikan, id_rt) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama_lengkap').value = nama_lengkap;
        document.getElementById('edit_nomor_induk_kartu_keluarga').value = nomor_induk_kartu_keluarga;
        document.getElementById('edit_nik_kepala_keluarga').value = nik_kepala_keluarga;
        document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
        document.getElementById('edit_tempat_lahir').value = tempat_lahir;
        document.getElementById('edit_pekerjaan').value = pekerjaan;
        document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
        document.getElementById('edit_agama').value = agama;
        document.getElementById('edit_pendidikan').value = pendidikan;
        document.getElementById('edit_id_rt').value = id_rt;
        editModal.show();
    }
    </script>

    <?php include_once 'fitur/js.php'; ?>
</body>

</html>

</html>
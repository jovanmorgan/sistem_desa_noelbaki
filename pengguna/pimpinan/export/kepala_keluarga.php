<?php include '../fitur/nama_halaman.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head_export.php'; ?>

<body translate="no">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Data Export <?= $page_title ?> </h3>
                    </div>
                    <?php
                    include '../../../keamanan/koneksi.php';

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
                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                            <table id="example" class="table table-hover text-center mt-3"
                                style="border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">
                                            Nomor</th>
                                        <th style="white-space: nowrap;">
                                            RT</th>
                                        <th style="white-space: nowrap;">
                                            Nomor Induk Kartu Keluarga</th>
                                        <th style="white-space: nowrap;">
                                            Nomor Induk Kependudukan</th>
                                        <th style="white-space: nowrap;">
                                            Nama Lengkap</th>
                                        <th style="white-space: nowrap;">
                                            Tempat Lahir</th>
                                        <th style="white-space: nowrap;">
                                            Tanggal Lahir</th>
                                        <th en style="white-space: nowrap;">
                                            Jenis Kelamin</th>
                                        <th style="white-space: nowrap;">
                                            Pekerjaan</th>
                                        <th style="white-space: nowrap;">
                                            Agama</th>
                                        <th style="white-space: nowrap;">
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
                            <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../fitur/js_export.php'; ?>

</body>

</html>
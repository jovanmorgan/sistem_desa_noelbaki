  <?php
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data keluarga_kurang_mampu dengan relasi
    $query = "
    SELECT 
        kkm.id_kkm,
        kkm.id_rt,
        kkm.id_kepala_keluarga,
        rt.nama_rt,
        kk.nama_lengkap AS nama_kepala_keluarga,
        kk.nomor_induk_kartu_keluarga,
        kkm.foto_rumah,
        kkm.foto_keluarga,
        kkm.pemasukan_perbulan,
        kkm.status_validasi
    FROM keluarga_kurang_mampu kkm
    JOIN rt ON kkm.id_rt = rt.id_rt
    JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
    WHERE rt.nama_rt LIKE ? OR kk.nama_lengkap LIKE ?
    LIMIT ?, ?
";
    $stmt = $koneksi->prepare($query);
    $search_param = '%' . $search . '%';
    $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hitung total halaman
    $total_query = "
    SELECT COUNT(*) as total
    FROM keluarga_kurang_mampu kkm
    JOIN rt ON kkm.id_rt = rt.id_rt
    JOIN anggota_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
    WHERE rt.nama_rt LIKE ? OR kk.nama_lengkap LIKE ?
";
    $stmt_total = $koneksi->prepare($total_query);
    $stmt_total->bind_param("ss", $search_param, $search_param);
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
                                      No</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Nama RT</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Kepala Keluarga</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      NIKK</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Foto Rumah</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Foto Keluarga</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Pemasukan Per Bulan</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Status Validasi</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                $nomor = $offset + 1;
                                while ($row = $result->fetch_assoc()) :
                                ?>
                                  <tr>
                                      <td class="align-middle text-center">
                                          <span class="text-secondary text-xs font-weight-bold"><?php echo $nomor++; ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span class="text-secondary text-xs font-weight-bold">RT
                                              :<?php echo htmlspecialchars($row['nama_rt']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_kepala_keluarga']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nomor_induk_kartu_keluarga']); ?></span>
                                      </td>
                                      <td class="align-middle text-center" style="cursor: pointer">
                                          <img src="../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_rumah']); ?>"
                                              alt="Foto Rumah" style="width: 80px; height: auto;"
                                              onclick="openImageModal('../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_rumah']); ?>')">
                                      </td>
                                      <td class="align-middle text-center" style="cursor: pointer">
                                          <img src="../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_keluarga']); ?>"
                                              alt="Foto Keluarga" style="width: 80px; height: auto;"
                                              onclick="openImageModal('../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_keluarga']); ?>')">
                                      </td>

                                      <td class="align-middle text-center">
                                          <span class="text-secondary text-xs font-weight-bold">
                                              <?php
                                                // Pemetaan opsi pemasukan per bulan
                                                $pemasukan_options = [
                                                    "Kurang Dari 500000" => "Kurang dari Rp 500.000",
                                                    "500000-1000000" => "Rp 500.000 - Rp 1.000.000",
                                                    "1000000-2000000" => "Rp 1.000.000 - Rp 2.000.000",
                                                    "2000000-3000000" => "Rp 2.000.000 - Rp 3.000.000",
                                                    "3000000-5000000" => "Rp 3.000.000 - Rp 5.000.000",
                                                    "5000000-10000000" => "Rp 5.000.000 - Rp 10.000.000",
                                                    "Lebih Dari 10000000" => "Lebih dari Rp 10.000.000"
                                                ];

                                                // Menampilkan data dengan pemetaan
                                                echo isset($pemasukan_options[$row['pemasukan_perbulan']])
                                                    ? $pemasukan_options[$row['pemasukan_perbulan']]
                                                    : "Data tidak valid";
                                                ?>
                                          </span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span class="badge 
        <?php
                                    if ($row['status_validasi'] == 'Disetujui') {
                                        echo 'bg-success'; // Hijau untuk Disetujui
                                    } elseif ($row['status_validasi'] == 'Tidak Disetujui') {
                                        echo 'bg-danger'; // Merah untuk Tidak Disetujui
                                    } elseif ($row['status_validasi'] == 'Dalam Proses') {
                                        echo 'bg-primary'; // Biru untuk Dalam Proses
                                    }
        ?>">
                                              <?php echo htmlspecialchars($row['status_validasi']); ?>
                                          </span>
                                      </td>


                                      <td class="align-middle text-center">
                                          <form action="export/kkm" method="GET" style="display: inline-block;" target="_blank">
                                              <input type="hidden" name="id_kkm" value="<?php echo $row['id_kkm']; ?>">
                                              <button type="submit" class="btn btn-warning btn-sm m-1">Cetak
                                                  PDF</button>
                                          </form>
                                          <button class="btn btn-success btn-sm mt-3"
                                              onclick="openEditModal('<?php echo $row['id_kkm']; ?>')">Validasi
                                              Status</button>
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
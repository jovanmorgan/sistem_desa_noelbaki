  <?php
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data kepala_keluarga dengan pencarian dan pagination
    $query = "
    SELECT 
        ak.id_anggota_keluarga,
        ak.id_kepala_keluarga,
        ak.id_rt,
        ak.nik_anggota_keluarga,
        rt.nama_rt,
        ak.nama_lengkap,
        kepala_keluarga.nomor_induk_kartu_keluarga,
        kepala_keluarga.nama_lengkap AS nama_kepala_keluarga,
        ak.jenis_kelamin,
        ak.tempat_lahir,
        ak.pekerjaan,
        ak.tanggal_lahir,
        ak.agama,
        ak.pendidikan
    FROM anggota_keluarga ak
    INNER JOIN kepala_keluarga ON ak.id_kepala_keluarga = kepala_keluarga.id_kepala_keluarga
    INNER JOIN rt ON ak.id_rt = rt.id_rt
    WHERE ak.nama_lengkap LIKE ? OR kepala_keluarga.nomor_induk_kartu_keluarga LIKE ? OR kepala_keluarga.nama_lengkap LIKE ? OR ak.jenis_kelamin LIKE ? 
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
    FROM kepala_keluarga ak
   INNER JOIN kepala_keluarga ON ak.id_kepala_keluarga = kepala_keluarga.id_kepala_keluarga
    INNER JOIN rt ON ak.id_rt = rt.id_rt
    WHERE ak.nama_lengkap LIKE ? OR kepala_keluarga.nomor_induk_kartu_keluarga LIKE ? OR kepala_keluarga.nama_lengkap LIKE ? OR ak.jenis_kelamin LIKE ? 
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
                                      Nama Kepala Keluarga</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Nik Anggota Keluarga</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Nama Lengkap</th>
                                  <th en
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Jenis Kelamin</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Tempat Lahir</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Pekerjaan</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Tanggal Lahir</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Agama</th>
                                  <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Pendidikan</th>
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
                                          <span class="text-secondary text-xs font-weight-bold">RT :
                                              <?php echo htmlspecialchars($row['nama_rt']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nomor_induk_kartu_keluarga']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_kepala_keluarga']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nik_anggota_keluarga']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['jenis_kelamin']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['tempat_lahir']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['pekerjaan']); ?></span>
                                      </td>
                                      <!-- buat format tanggal_lahir jadi hari, tanggal-bulan-tahun -->
                                      <td class="align-middle text-center"><span
                                              class="text-secondary text-xs font-weight-bold"><?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['agama']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['pendidikan']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <button class="btn btn-primary btn-sm mt-3"
                                              onclick="openEditModal('<?php echo $row['id_anggota_keluarga']; ?>','<?php echo $row['id_kepala_keluarga']; ?>','<?php echo $row['nama_lengkap']; ?>','<?php echo $row['nik_anggota_keluarga']; ?>','<?php echo $row['jenis_kelamin']; ?>','<?php echo $row['tempat_lahir']; ?>','<?php echo $row['pekerjaan']; ?>','<?php echo $row['tanggal_lahir']; ?>','<?php echo $row['agama']; ?>','<?php echo $row['pendidikan']; ?>','<?php echo $row['id_rt']; ?>')">Edit</button>
                                          <button class="btn btn-danger btn-sm mt-3"
                                              onclick="hapus('<?php echo $row['id_anggota_keluarga']; ?>')">Hapus</button>
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
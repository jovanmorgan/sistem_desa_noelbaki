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
        <?php
        include '../../keamanan/koneksi.php';

        // Query untuk menghitung jumlah pekerjaan berdasarkan RT
        $query_pekerjaan = "
    SELECT 
        rt.nama_rt,
        kk.pekerjaan,
        kk.id_rt,
        COUNT(kk.pekerjaan) AS total_pekerjaan
    FROM kepala_keluarga kk
    INNER JOIN rt ON kk.id_rt = rt.id_rt
    WHERE kk.id_rt = '$id_rt'
    GROUP BY rt.nama_rt, kk.pekerjaan
    ORDER BY rt.nama_rt, total_pekerjaan DESC
";

        $result_pekerjaan = mysqli_query($koneksi, $query_pekerjaan);

        // Inisialisasi array untuk data chart
        $rt_nama_pekerjaan = [];
        $pekerjaan_labels = [];
        $pekerjaan_data = [];

        // Fetch data
        while ($row = mysqli_fetch_assoc($result_pekerjaan)) {
            $rt_nama_pekerjaan[] = "RT" . $row['nama_rt'];
            $pekerjaan_labels[] = $row['pekerjaan'];
            $pekerjaan_data[] = $row['total_pekerjaan'];
        }

        // Membersihkan hasil query
        mysqli_free_result($result_pekerjaan);


        // Query untuk menghitung jumlah Pria dan Wanita berdasarkan RT
        $query_jenis_kelamin = "
    SELECT 
        rt.nama_rt,
        SUM(CASE WHEN ak.jenis_kelamin = 'Pria' THEN 1 ELSE 0 END) AS total_pria,
        SUM(CASE WHEN ak.jenis_kelamin = 'Wanita' THEN 1 ELSE 0 END) AS total_wanita
    FROM anggota_keluarga ak
    INNER JOIN rt ON ak.id_rt = rt.id_rt
    WHERE ak.id_rt = '$id_rt' 
    GROUP BY rt.nama_rt
    ORDER BY rt.nama_rt
";

        $result_jenis_kelamin = mysqli_query($koneksi, $query_jenis_kelamin);

        // Inisialisasi array untuk data chart
        $rt_nama = [];
        $total_pria = [];
        $total_wanita = [];

        // Fetch data
        while ($row = mysqli_fetch_assoc($result_jenis_kelamin)) {
            $rt_nama[] = "RT" . $row['nama_rt'];
            $total_pria[] = $row['total_pria'];
            $total_wanita[] = $row['total_wanita'];
        }

        // Membersihkan hasil query
        mysqli_free_result($result_jenis_kelamin);

        // Query untuk menghitung jumlah validasi berdasarkan status di masing-masing RT
        $query_validasi = "
    SELECT 
        kk.id_rt,
        rt.nama_rt,
        SUM(CASE WHEN kkm.status_validasi = 'Disetujui' THEN 1 ELSE 0 END) AS total_disetujui,
        SUM(CASE WHEN kkm.status_validasi = 'Tidak Disetujui' THEN 1 ELSE 0 END) AS total_tidak_disetujui,
        SUM(CASE WHEN kkm.status_validasi = 'Dalam Proses' THEN 1 ELSE 0 END) AS total_dalam_proses
    FROM keluarga_kurang_mampu kkm
    INNER JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
    INNER JOIN rt ON kk.id_rt = rt.id_rt
    GROUP BY kk.id_rt, rt.nama_rt
    ORDER BY rt.nama_rt
";

        $result_validasi = mysqli_query($koneksi, $query_validasi);

        // Inisialisasi array untuk data chart
        $rt_nama = [];
        $total_disetujui = [];
        $total_tidak_disetujui = [];
        $total_dalam_proses = []; // Array untuk status 'Dalam Proses'

        // Fetch data
        while ($row = mysqli_fetch_assoc($result_validasi)) {
            $rt_nama[] = "RT" . $row['nama_rt'];
            $total_disetujui[] = $row['total_disetujui'];
            $total_tidak_disetujui[] = $row['total_tidak_disetujui'];
            $total_dalam_proses[] = $row['total_dalam_proses']; // Menambahkan data 'Dalam Proses'
        }

        // Membersihkan hasil query
        mysqli_free_result($result_validasi);


        // Pastikan $id_rt sudah didefinisikan sebelumnya
        $query_jenis_bantuan = "
SELECT 
    kk.id_rt,
    rt.nama_rt,
    kk.nama_lengkap AS kepala_keluarga,
    pb.jenis_bantuan,
    COUNT(pb.jenis_bantuan) AS total_bantuan
FROM permohonan_bantuan pb
INNER JOIN kepala_keluarga kk ON pb.id_kepala_keluarga = kk.id_kepala_keluarga
INNER JOIN rt ON kk.id_rt = rt.id_rt
WHERE kk.id_rt = '$id_rt'  -- Menambahkan filter berdasarkan id_rt
GROUP BY kk.id_rt, rt.nama_rt, kk.nama_lengkap, pb.jenis_bantuan
ORDER BY rt.nama_rt, kk.nama_lengkap, pb.jenis_bantuan
";

        $result_jenis_bantuan = mysqli_query($koneksi, $query_jenis_bantuan);

        // Inisialisasi array untuk data
        $data_rt = [];
        while ($row = mysqli_fetch_assoc($result_jenis_bantuan)) {
            $data_rt[$row['nama_rt']][] = [
                'kepala_keluarga' => $row['kepala_keluarga'],
                'jenis_bantuan' => $row['jenis_bantuan'],
                'total_bantuan' => $row['total_bantuan']
            ];
        }

        // Membersihkan hasil query
        mysqli_free_result($result_jenis_bantuan);
        // Pastikan $id_rt sudah didefinisikan sebelumnya
        $query_pemasukan = "
SELECT 
    kk.id_rt,
    rt.nama_rt,
    COUNT(kkm.id_kepala_keluarga) AS total_kepala_keluarga,
    SUM(kkm.pemasukan_perbulan) AS total_pemasukan,
    AVG(kkm.pemasukan_perbulan) AS rata_rata_pemasukan
FROM keluarga_kurang_mampu kkm
INNER JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
INNER JOIN rt ON kk.id_rt = rt.id_rt
WHERE kk.id_rt = '$id_rt'  -- Menambahkan filter berdasarkan id_rt
GROUP BY kk.id_rt, rt.nama_rt
ORDER BY rt.nama_rt
";

        $result_pemasukan = mysqli_query($koneksi, $query_pemasukan);

        // Inisialisasi array untuk data chart
        $rt_nama = [];
        $total_pemasukan = [];
        $rata_rata_pemasukan = [];

        // Fetch data
        while ($row = mysqli_fetch_assoc($result_pemasukan)) {
            $rt_nama[] = "RT" . $row['nama_rt'];
            $total_pemasukan[] = $row['total_pemasukan'];
            $rata_rata_pemasukan[] = $row['rata_rata_pemasukan'];
        }

        // Membersihkan hasil query
        mysqli_free_result($result_pemasukan);

        // Pastikan $id_rt sudah didefinisikan sebelumnya
        $query_status_validasi = "
SELECT 
    kk.id_rt,
    rt.nama_rt,
    kk.nama_lengkap AS kepala_keluarga,
    SUM(CASE WHEN pb.status_validasi = 'disetujui' THEN 1 ELSE 0 END) AS total_disetujui,
    SUM(CASE WHEN pb.status_validasi = 'tidak disetujui' THEN 1 ELSE 0 END) AS total_tidak_disetujui
FROM permohonan_bantuan pb
INNER JOIN kepala_keluarga kk ON pb.id_kepala_keluarga = kk.id_kepala_keluarga
INNER JOIN rt ON kk.id_rt = rt.id_rt
WHERE kk.id_rt = '$id_rt'  -- Menambahkan filter berdasarkan id_rt
GROUP BY kk.id_rt, rt.nama_rt, kk.nama_lengkap
ORDER BY rt.nama_rt, kk.nama_lengkap
";

        $result_status_validasi = mysqli_query($koneksi, $query_status_validasi);

        // Inisialisasi array untuk data
        $data_rt_validasi = [];
        while ($row = mysqli_fetch_assoc($result_status_validasi)) {
            $data_rt_validasi[$row['nama_rt']][] = [
                'kepala_keluarga' => $row['kepala_keluarga'],
                'total_disetujui' => $row['total_disetujui'],
                'total_tidak_disetujui' => $row['total_tidak_disetujui']
            ];
        }

        // Membersihkan hasil query
        mysqli_free_result($result_status_validasi);

        $tables = [
            'kepala_keluarga' => [
                'label' => 'Kepala Keluarga',
                'icon' => 'fas fa-home',
                'color' => '#00FF00',
            ],
            'anggota_keluarga' => [
                'label' => 'Anggota Keluarga',
                'icon' => 'fas fa-user',
                'color' => '#0000FF',
            ],
            'keluarga_kurang_mampu' => [
                'label' => 'Keluarga Kurang Mampu',
                'icon' => 'fas fa-users',
                'color' => '#800080',
            ],
            'permohonan_bantuan' => [
                'label' => 'Permohonan Bantuan',
                'icon' => 'fas fa-hand-holding-heart',
                'color' => '#A52A2A',
            ],
        ];

        $counts = [];

        foreach ($tables as $table => $details) {
            // Tambahkan klausa WHERE untuk memfilter data berdasarkan id_rt
            $query = "SELECT COUNT(*) as count FROM $table WHERE id_rt = '$id_rt'";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $counts[$table] = $row['count'];
                mysqli_free_result($result);
            } else {
                // Tangani jika query gagal
                $counts[$table] = 0; // Set default 0 jika terjadi kesalahan
                error_log("Error executing query for table $table: " . mysqli_error($koneksi));
            }
        }

        mysqli_close($koneksi);
        ?>

        <div class="container-fluid py-4">
            <div class="row">
                <?php foreach ($tables as $table => $details): ?>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 overflow-hidden mt-3">
                        <div class="card position-relative">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                                <?php echo $details['label']; ?>
                                            </p>
                                            <h5 class="font-weight-bolder">
                                                <?php echo isset($counts[$table]) ? $counts[$table] . " Data" : "0 Data"; ?>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end z-index-2">
                                        <div class="icon icon-shape shadow-primary text-center rounded-circle"
                                            style="background-color: <?php echo $details['color']; ?>;">
                                            <i class="<?php echo $details['icon']; ?> text-lg opacity-10"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Icon Background -->
                            <i class="<?php echo $details['icon']; ?> position-absolute z-index-1"
                                style="font-size: 100px; opacity: 0.2; bottom: 1px; right: 10px; color: <?php echo $details['color']; ?>;"
                                aria-hidden="true"></i>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>


            <div class="row mt-4">
                <!-- Diagram Pekerjaan Berdasarkan RT -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Pekerjaan Berdasarkan RT</h5>
                            <!-- Bar Chart -->
                            <canvas id="pekerjaanChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#pekerjaanChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($rt_nama_pekerjaan); ?>, // RT Names
                                            datasets: [{
                                                label: "Jumlah Pekerjaan",
                                                data: <?= json_encode($pekerjaan_data); ?>, // Total pekerjaan
                                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                                borderColor: "rgb(75, 192, 192)",
                                                borderWidth: 1,
                                            }],
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>

                <!-- Diagram Jenis Kelamin Berdasarkan RT -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Jenis Kelamin Berdasarkan RT</h5>
                            <!-- Bar Chart -->
                            <canvas id="jenisKelaminChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#jenisKelaminChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($rt_nama); ?>,
                                            datasets: [{
                                                    label: "Pria",
                                                    data: <?= json_encode($total_pria); ?>,
                                                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                                                    borderColor: "rgb(54, 162, 235)",
                                                    borderWidth: 1,
                                                },
                                                {
                                                    label: "Wanita",
                                                    data: <?= json_encode($total_wanita); ?>,
                                                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                                                    borderColor: "rgb(255, 99, 132)",
                                                    borderWidth: 1,
                                                },
                                            ],
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>


                <!-- Diagram Status Validasi Berdasarkan RT -->
                <div class="col-lg-6 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Status Validasi Keluarga Kurang Mampu Berdasarkan RT</h5>
                            <!-- Bar Chart -->
                            <canvas id="statusValidasiChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#statusValidasiChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($rt_nama); ?>, // Menampilkan nama RT
                                            datasets: [{
                                                    label: "Disetujui",
                                                    data: <?= json_encode($total_disetujui); ?>,
                                                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                                                    borderColor: "rgb(75, 192, 192)",
                                                    borderWidth: 1,
                                                },
                                                {
                                                    label: "Tidak Disetujui",
                                                    data: <?= json_encode($total_tidak_disetujui); ?>,
                                                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                                                    borderColor: "rgb(255, 99, 132)",
                                                    borderWidth: 1,
                                                },
                                                {
                                                    label: "Dalam Proses", // Menambahkan status 'Dalam Proses'
                                                    data: <?= json_encode($total_dalam_proses); ?>,
                                                    backgroundColor: "rgba(255, 159, 64, 0.2)",
                                                    borderColor: "rgb(255, 159, 64)",
                                                    borderWidth: 1,
                                                },
                                            ],
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>

                <!-- Diagram Pemasukan Per Bulan Berdasarkan RT -->
                <div class="col-lg-6 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Pemasukan Per Bulan Berdasarkan RT</h5>
                            <!-- Bar Chart -->
                            <canvas id="pemasukanPerBulanChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#pemasukanPerBulanChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($rt_nama); ?>,
                                            datasets: [{
                                                    label: "Total Pemasukan",
                                                    data: <?= json_encode($total_pemasukan); ?>,
                                                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                                                    borderColor: "rgb(54, 162, 235)",
                                                    borderWidth: 1,
                                                },
                                                {
                                                    label: "Rata-rata Pemasukan",
                                                    data: <?= json_encode($rata_rata_pemasukan); ?>,
                                                    backgroundColor: "rgba(255, 206, 86, 0.2)",
                                                    borderColor: "rgb(255, 206, 86)",
                                                    borderWidth: 1,
                                                },
                                            ],
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>

                <!-- Tabel Jenis Bantuan Berdasarkan RT -->
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Jenis Bantuan Berdasarkan RT</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>RT</th>
                                        <th>Kepala Keluarga</th>
                                        <th>Jenis Bantuan</th>
                                        <th>Total Bantuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_rt as $rt => $bantuans): ?>
                                        <?php foreach ($bantuans as $index => $bantuan): ?>
                                            <tr>
                                                <?php if ($index == 0): ?>
                                                    <td rowspan="<?= count($bantuans); ?>"><?= htmlspecialchars($rt); ?></td>
                                                <?php endif; ?>
                                                <?php if ($index == 0 || $bantuans[$index - 1]['kepala_keluarga'] != $bantuan['kepala_keluarga']): ?>
                                                    <td><?= htmlspecialchars($bantuan['kepala_keluarga']); ?></td>
                                                <?php else:
                                                    $bantuans[$index - 1]['kepala_keluarga'];
                                                    $bantuan['kepala_keluarga'];
                                                ?>

                                                <?php endif; ?>
                                                <td><?= htmlspecialchars($bantuan['jenis_bantuan']); ?></td>
                                                <td><?= htmlspecialchars($bantuan['total_bantuan']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel Status Validasi Berdasarkan RT -->
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Status Validasi Berdasarkan RT</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>RT</th>
                                        <th>Kepala Keluarga</th>
                                        <th>Total Disetujui</th>
                                        <th>Total Tidak Disetujui</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_rt_validasi as $rt => $validasis): ?>
                                        <?php foreach ($validasis as $index => $validasi): ?>
                                            <tr>
                                                <?php if ($index == 0): ?>
                                                    <td rowspan="<?= count($validasis); ?>"><?= htmlspecialchars($rt); ?></td>
                                                <?php endif; ?>
                                                <td><?= htmlspecialchars($validasi['kepala_keluarga']); ?></td>
                                                <td><?= htmlspecialchars($validasi['total_disetujui']); ?></td>
                                                <td><?= htmlspecialchars($validasi['total_tidak_disetujui']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <!-- footer -->
            <?php include_once 'fitur/footer.php'; ?>

        </div>
    </main>

    <!-- js bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->

    <!--   Core JS Files   -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
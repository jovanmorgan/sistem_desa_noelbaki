<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="../../assets/img-umum/umum/logo.png" type="" />

    <!-- Stlylesheet -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/no-ui-slider/jquery.nouislider.css" type="text/css" />
    <!-- link icon nya -->
    <link href="../../Font-Awesome/css/all.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css" type="" /> -->
    <!-- Skin Color -->
    <link rel="stylesheet" href="css/colors/green.css" id="color-skins" />
</head>

<body>

    <!-- Start Preloader -->
    <div id="loader">
        <div class="spinner">
            <div class="cube cube0"></div>
            <div class="cube cube1"></div>
            <div class="cube cube2"></div>
            <div class="cube cube3"></div>
            <div class="cube cube4"></div>
            <div class="cube cube5"></div>
            <div class="cube cube6"></div>
            <div class="cube cube7"></div>
            <div class="cube cube8"></div>
            <div class="cube cube9"></div>
            <div class="cube cube10"></div>
            <div class="cube cube11"></div>
            <div class="cube cube12"></div>
            <div class="cube cube13"></div>
            <div class="cube cube14"></div>
            <div class="cube cube15"></div>
        </div>
    </div>
    <!-- End Preloader -->

    <!-- Start Header -->
    <header>
        <nav class="navbar navbar-default navbar-alt" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand to-top" rel="home" href="#">
                        <img src="../../assets/img-umum/umum/lg1.png" alt="Visual" class="logo-big"
                            style="width: 350px; position: relative; bottom: 85px;">
                        <img src="../../assets/img-umum/umum/lg3.png" alt="Visual" class="logo-small"
                            style="width: 350px; position: relative; bottom: 284px;">
                    </a>
                </div>
                <?php
                // Mendapatkan URI dari halaman saat ini
                $currentUri = $_SERVER['REQUEST_URI'];
                ?>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="nav navbar-nav navbar-right">
                        <li id="home-link"
                            class="<?= (strpos($currentUri, '#home-revolution-slider') !== false) ? 'active' : '' ?>">
                            <a href="#home-revolution-slider">
                                Home
                            </a>
                        </li>
                        <li id="tentang-kami-link"
                            class="<?= (strpos($currentUri, '#tentang_kami') !== false) ? 'active' : '' ?>">
                            <a href="#tentang_kami">
                                Tentang Kami
                            </a>
                        </li>
                        <li id="bantuan-link" class="<?= (strpos($currentUri, 'bantuan') !== false) ? 'active' : '' ?>">
                            <a href="bantuan">
                                Bantuan
                            </a>
                        </li>
                        <li id="kontak-link" class="<?= (strpos($currentUri, '#kontak') !== false) ? 'active' : '' ?>">
                            <a href="#kontak">
                                Kontak
                            </a>
                        </li>
                        <li id="login-link" class="<?= (strpos($currentUri, 'login') !== false) ? 'active' : '' ?>">
                            <a href="../../berlangganan/login">
                                Login
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
            <!-- /.container -->
        </nav>
    </header>
    <!-- End Header -->

    <!-- Start Home Revolution Slider Parallax Section -->
    <section id="home-revolution-slider">
        <div class="hero">
            <div class="tp-banner-container">
                <div class="tp-banner">
                    <ul>
                        <!-- SLIDE 1: Kantor Desa Noelbaki -->
                        <li data-transition="fade" data-slotamount="7" data-masterspeed="2000"
                            data-thumb="../../assets/img-umum/umum/ft1.jpg" data-delay="10000" data-saveperformance="on"
                            data-title="Kantor Desa Noelbaki">
                            <img src="../../assets/img-umum/umum/ft1.jpg" alt="slidebg1" data-bgposition="center top"
                                data-bgfit="cover" data-bgrepeat="no-repeat">

                            <!-- Home Heading -->
                            <div class="tp-caption sft" data-x="center" data-y="260" data-speed="1200" data-start="1100"
                                data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none"
                                data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <h2 class="home-heading op-1">Kantor Desa Noelbaki</h2>
                            </div>
                            <!-- Home Subheading -->
                            <div class="tp-caption home-subheading sft" data-x="center" data-y="360" data-speed="1200"
                                data-start="1350" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-1" style="color: white; font-size: 20px;">
                                    Melayani administrasi kependudukan, perizinan, dan pemberdayaan masyarakat.
                                </div>
                            </div>
                            <!-- Home Button -->
                            <div class="tp-caption home-button sft fadeout" data-x="center" data-y="400"
                                data-speed="1200" data-start="1550" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-1">
                                    <a href="#features" class="btn btn-primary btn-scroll">
                                        Pelajari Lebih Lanjut
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- SLIDE 2: Permohonan Bantuan -->
                        <li data-transition="fade" data-slotamount="7" data-masterspeed="2000"
                            data-thumb="../../assets/img-umum/umum/ft2.jpg" data-delay="10000" data-saveperformance="on"
                            data-title="Permohonan Bantuan">
                            <img src="../../assets/img-umum/umum/ft2.jpg" alt="slidebg1" data-bgposition="center top"
                                data-bgfit="cover" data-bgrepeat="no-repeat">

                            <!-- Home Heading -->
                            <div class="tp-caption sft" data-x="center" data-y="260" data-speed="1200" data-start="1100"
                                data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none"
                                data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <h2 class="home-heading op-2">Permohonan Bantuan</h2>
                            </div>
                            <!-- Home Subheading -->
                            <div class="tp-caption home-subheading sft fadeout" data-x="center" data-y="360"
                                data-speed="1200" data-start="1350" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-2" style="color: white; font-size: 20px;">
                                    Membantu keluarga kurang mampu dengan layanan dan pendampingan terbaik.
                                </div>
                            </div>
                            <!-- Home Button -->
                            <div class="tp-caption home-button sft fadeout" data-x="center" data-y="400"
                                data-speed="1200" data-start="1550" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-2">
                                    <a href="#tentang_kami" class="btn btn-primary btn-scroll">
                                        Telusuri Layanan
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- SLIDE 3: Keluarga Kurang Mampu -->
                        <li data-transition="fade" data-slotamount="7" data-masterspeed="2000"
                            data-thumb="../../assets/img-umum/umum/ft3.jpg" data-delay="10000" data-saveperformance="on"
                            data-title="Pendataan Keluarga Kurang Mampu">
                            <img src="../../assets/img-umum/umum/ft3.jpg" alt="slidebg1" data-bgposition="center top"
                                data-bgfit="cover" data-bgrepeat="no-repeat">

                            <!-- Home Heading -->
                            <div class="tp-caption sft" data-x="center" data-y="260" data-speed="1200" data-start="1100"
                                data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none"
                                data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <h2 class="home-heading op-3">Keluarga Kurang Mampu</h2>
                            </div>
                            <!-- Home Subheading -->
                            <div class="tp-caption home-subheading sft fadeout" data-x="center" data-y="360"
                                data-speed="1200" data-start="1350" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-3" style="color: white; font-size: 20px;">
                                    Data yang akurat untuk mendukung bantuan tepat sasaran.
                                </div>
                            </div>
                            <!-- Home Button -->
                            <div class="tp-caption home-button sft fadeout" data-x="center" data-y="400"
                                data-speed="1200" data-start="1550" data-easing="Power3.easeInOut" data-splitin="none"
                                data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"
                                data-endspeed="300"
                                style="z-index: 4; max-width: auto; max-height: auto; white-space:normal;">
                                <div class="op-3">
                                    <a href="#tentang_kami" class="btn btn-primary btn-scroll">
                                        Telusuri Layanan
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="tp-bannertimer"></div>
                </div>
                <div class="home-bottom">
                    <div class="container text-center">
                        <div class="move bounce">
                            <a href="#features" class="ion-ios-arrow-down btn-scroll">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Home Revolution Slider Parallax Section -->

    <div class="site-wrapper content">

        <!-- Start Features Section -->
        <section id="features">
            <div class="container">
                <div class="col-md-12 text-center wow fadeInUp">
                    <h3 class="section-title">Layanan Utama Kami</h3>
                    <p class="subheading">Kami menyediakan layanan <span class="highlight">berbasis data</span> untuk
                        mendukung
                        masyarakat desa</p>
                </div>
                <div class="row features-row wow fadeInUp">
                    <div class="col-md-4 col-sm-12 feature-column">
                        <div class="feature-icon">
                            <i class="fa fa-user-friends size-2x highlight"></i>
                            <i class="fa fa-user-friends back-icon"></i>
                        </div>
                        <div class="feature-info">
                            <h4>Pendataan Kepala Keluarga</h4>
                            <p class="feature-description">Layanan untuk mendata dan memperbarui informasi kepala
                                keluarga
                                secara
                                berkala.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 feature-column">
                        <div class="feature-icon">
                            <i class="fa fa-users size-2x highlight"></i>
                            <i class="fa fa-users back-icon"></i>
                        </div>
                        <div class="feature-info">
                            <h4>Pendataan Anggota Keluarga</h4>
                            <p class="feature-description">Penyimpanan data anggota keluarga untuk mendukung
                                arg administrasi desa
                                yang
                                lebih baik.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 feature-column">
                        <div class="feature-icon">
                            <i class="fa fa-hands-helping size-2x highlight"></i>
                            <i class="fa fa-hands-helping back-icon"></i>
                        </div>
                        <div class="feature-info">
                            <h4>Pendataan Keluarga Kurang Mampu</h4>
                            <p class="feature-description">Mendukung program bantuan dengan mendata keluarga kurang
                                mampu
                                secara
                                akurat.</p>
                        </div>
                    </div>
                </div>
                <div class="row wow fadeInUp">
                    <div class="col-md-4 col-sm-12 feature-column">
                        <div class="feature-icon">
                            <i class="fa fa-envelope size-2x highlight"></i>
                            <i class="fa fa-envelope back-icon"></i>
                        </div>
                        <div class="feature-info">
                            <h4>Permohonan Bantuan</h4>
                            <p class="feature-description">Mempermudah masyarakat dalam mengajukan permohonan bantuan
                                melalui
                                sistem
                                terpadu.</p>
                        </div>
                    </div>
                </div>
        </section>
        <!-- End Features Section -->

        <!-- Start About Section -->
        <section id="tentang_kami">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-left about-text">
                        <h3 class="wow fadeInUp">Sejarah Kami</h3>
                        <p class="wow fadeInUp">
                            Kantor Desa adalah pusat pelayanan yang didirikan untuk memenuhi kebutuhan masyarakat dalam
                            berbagai
                            aspek administratif dan sosial. Kami berkomitmen untuk memberikan pelayanan yang transparan,
                            efisien, dan
                            berorientasi pada kemajuan desa. Dengan sejarah panjang dalam melayani masyarakat, kami
                            terus
                            berkembang
                            untuk menciptakan desa yang lebih maju dan sejahtera.
                        </p>
                        <p class="wow fadeInUp">
                            <button type="button" class="btn btn-primary btn-md">Hubungi Kami</button>
                        </p>
                    </div>
                    <div class="col-md-6 wow fadeInUp about-text">
                        <h3 class="wow fadeInUp">Kantor Desa</h3>
                        <!-- Tambahkan Gambar -->
                        <div class="achievement-image text-center mb-4">
                            <img src="../../assets/img-umum/umum/ft1.jpg" alt="Achievement Illustration"
                                class="img-fluid">
                        </div>
                        <div class="progress-bars" style="margin-top: 20px;">
                            <p>Peningkatan Layanan Publik</p>
                            <div class="progress" data-percent="90%">
                                <div class="progress-bar">
                                    <span class="progress-bar-tooltip">90%</span>
                                </div>
                            </div>
                            <p>Keterlibatan Masyarakat</p>
                            <div class="progress" data-percent="85%">
                                <div class="progress-bar">
                                    <span class="progress-bar-tooltip">85%</span>
                                </div>
                            </div>
                            <p>Pembangunan Infrastruktur Desa</p>
                            <div class="progress" data-percent="80%">
                                <div class="progress-bar">
                                    <span class="progress-bar-tooltip">80%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->

        <?php
        // Koneksi ke database
        include '../../keamanan/koneksi.php';

        // Query untuk menghitung jumlah data dari masing-masing tabel
        $query_kepala_keluarga = "SELECT COUNT(*) AS total_kepala_keluarga FROM kepala_keluarga";
        $query_anggota_keluarga = "SELECT COUNT(*) AS total_anggota_keluarga FROM anggota_keluarga";
        $query_keluarga_kurang_mampu = "SELECT COUNT(*) AS total_keluarga_kurang_mampu FROM keluarga_kurang_mampu";
        $query_permohonan_bantuan = "SELECT COUNT(*) AS total_permohonan_bantuan FROM permohonan_bantuan";

        // Eksekusi query
        $result_kepala_keluarga = mysqli_query($koneksi, $query_kepala_keluarga);
        $result_anggota_keluarga = mysqli_query($koneksi, $query_anggota_keluarga);
        $result_keluarga_kurang_mampu = mysqli_query($koneksi, $query_keluarga_kurang_mampu);
        $result_permohonan_bantuan = mysqli_query($koneksi, $query_permohonan_bantuan);

        // Ambil hasil query
        $row_kepala_keluarga = mysqli_fetch_assoc($result_kepala_keluarga);
        $row_anggota_keluarga = mysqli_fetch_assoc($result_anggota_keluarga);
        $row_keluarga_kurang_mampu = mysqli_fetch_assoc($result_keluarga_kurang_mampu);
        $row_permohonan_bantuan = mysqli_fetch_assoc($result_permohonan_bantuan);

        // Tutup koneksi
        mysqli_close($koneksi);
        ?>

        <style>
            .parallax-section-5 {
                background-image: url(../../assets/img-umum/umum/ft2.jpg);
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .parallax-section-5::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.6);
                /* Gradasi putih */
                z-index: 1;
            }

            .parallax-section-5 .container {
                position: relative;
                z-index: 2;
                /* Menempatkan teks di atas gradasi */
            }

            .white {
                color: #fff;
                /* Pastikan teksnya berwarna putih untuk kontras yang lebih baik */
            }
        </style>

        <!-- Start Fun Facts Section -->
        <section id="fun-facts" class="parallax-section-5">
            <div class="container">
                <div class="col-md-12 text-center white wow fadeInUp">
                    <h3 class="section-title">Data Layanan Kami</h3>
                    <p class="subheading">Sejau ini adala jumlah data kami. Yang Sudah di data</p>
                </div>
                <div class="counter-row row text-center wow fadeInUp">
                    <div class="col-md-3 col-sm-6 fact-container">
                        <div class="fact">
                            <span
                                class="counter highlight"><?= htmlspecialchars($row_kepala_keluarga['total_kepala_keluarga']); ?></span>
                            <h4>Kepala Keluarga</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 fact-container">
                        <div class="fact">
                            <span
                                class="counter highlight"><?= htmlspecialchars($row_anggota_keluarga['total_anggota_keluarga']); ?></span>
                            <h4>Anggota Keluarga</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 fact-container">
                        <div class="fact">
                            <span
                                class="counter highlight"><?= htmlspecialchars($row_keluarga_kurang_mampu['total_keluarga_kurang_mampu']); ?></span>
                            <h4>Keluarga Kurang Mampu</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 fact-container">
                        <div class="fact">
                            <span
                                class="counter highlight"><?= htmlspecialchars($row_permohonan_bantuan['total_permohonan_bantuan']); ?></span>
                            <h4>Permohonan Bantuan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <style>
            /* Center Align Styling */
            .centered-contact {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
            }

            .centered-contact .icon-box {
                font-size: 40px;
                color: #5cb85c;
                background-color: #ffffff;
                padding: 15px;
                border-radius: 50%;
                margin-bottom: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .centered-contact .text-muted {
                font-size: 14px;
                color: #6c757d;
                margin-bottom: 5px;
            }

            .centered-contact .fw-bold {
                font-size: 18px;
                font-weight: 600;
                color: #343a40;
                margin-bottom: 0;
            }

            .centered-contact .fa {
                font-size: 40px;
                color: #5cb85c;
            }

            /* Styling the container to ensure all items are aligned in one row */
            .contact-container {
                display: flex;
                justify-content: space-between;
                /* Distribute space evenly */
                gap: 30px;
                /* Add space between columns */
                flex-wrap: wrap;
                /* Allow wrapping on smaller screens */
            }

            /* Styling each contact section to take up equal width */
            .contact-item {
                flex: 1 1 30%;
                /* Make each item take up 30% width, and allow it to grow/shrink */
                min-width: 250px;
                /* Set a minimum width for each item */
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Responsive Styling */
            @media (max-width: 768px) {
                .contact-container {
                    flex-direction: column;
                    /* Stack items vertically on smaller screens */
                    align-items: center;
                }

                .contact-item {
                    margin-bottom: 20px;
                    /* Add space between items when stacked */
                    width: 80%;
                    /* Set width to 80% of the container */
                }

                .contact-item .icon-box {
                    font-size: 30px;
                    margin-right: 15px;
                }

                .contact-item .text-muted,
                .contact-item .fw-bold {
                    text-align: left;
                }
            }
        </style>

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

        <!-- Contact Section -->
        <section id="kontak" style="margin-top: 50px;">
            <div id="load_data">
                <div class="container-xxl py-5">
                    <div class="container">
                        <div class="contact-container">

                            <!-- Address Section -->
                            <div class="contact-item">
                                <div class="icon-box">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>
                                <p class="text-muted mb-1">Alamat Gereja</p>
                                <h5 class="fw-bold mb-0"><?= htmlspecialchars($alamat); ?></h5>
                            </div>

                            <!-- Phone Section -->
                            <div class="contact-item">
                                <div class="icon-box">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <p class="text-muted mb-1">Hubungi Kami</p>
                                <h5 class="fw-bold mb-0"><?= htmlspecialchars($nomor_telpon); ?></h5>
                            </div>

                            <!-- Email Section -->
                            <div class="contact-item">
                                <div class="icon-box">
                                    <i class="fa fa-envelope-open"></i>
                                </div>
                                <p class="text-muted mb-1">Email Kami</p>
                                <h5 class="fw-bold mb-0"><?= htmlspecialchars($email); ?></h5>
                            </div>

                        </div>

                        <!-- Map Section -->
                        <div class="row g-4 mt-4" style="margin-top: 50px;">
                            <div class="col-lg-12">
                                <div class="h-100" style="max-height: 400px; width: 100%;">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.306918229313!2d123.7071739!3d-10.1286378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c56817ea92e5767%3A0x98b915bd574e1973!2sKantor%20DESA%20NOELBAKI!5e0!3m2!1sen!2sid!4v1702828290123!5m2!1sen!2sid"
                                        frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"
                                        style="width: 100%; height: 400px;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Start Footer 1 -->
        <footer id="footer">
            <!-- End Footer Widgets -->

            <div class="footer-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="section-title wow fadeInUp">Penutup</h3>
                            <p class="wow fadeInUp">Copyright © <script>
                                    document.write(new Date().getFullYear());
                                </script> Kantor Desa Noelbaki. Dibuat Olleh Elsa
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Copyright -->

        </footer>
        <!-- End Footer 1 -->

        <!-- Start Back To Top -->
        <a id="back-to-top">
            <i class="icon ion-chevron-up"></i>
        </a>
        <!-- End Back To Top -->

    </div>
    <!-- End Site Wrapper -->
    <!-- jQuery -->
    <script type="text/javascript" src="js/plugins/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/plugins/moderniz.min.js"></script>
    <script type="text/javascript" src="js/plugins/smoothscroll.min.js"></script>
    <script type="text/javascript" src="js/no-ui-slider/jquery.nouislider.all.min.js"></script>
    <script type="text/javascript" src="js/plugins/revslider.min.js"></script>
    <script type="text/javascript" src="js/plugins/waypoints.min.js"></script>
    <script type="text/javascript" src="js/plugins/parallax.min.js"></script>
    <script type="text/javascript" src="js/plugins/easign1.3.min.js"></script>
    <script type="text/javascript" src="js/plugins/cubeportfolio.min.js"></script>
    <script type="text/javascript" src="js/plugins/owlcarousel.min.js"></script>
    <script type="text/javascript" src="js/plugins/tweetie.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="js/plugins/gmap3.min.js"></script>
    <script type="text/javascript" src="js/plugins/wow.min.js"></script>
    <script type="text/javascript" src="js/plugins/counterup.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>

</html>
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
                  <img src="../../assets/img-umum/umum/lg3.png" alt="Visual" class="logo-big"
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
                     class="<?= (strpos($currentUri, '#home-revolution-') !== false) ? 'active' : '' ?>">
                     <a href="home" style="color: black;">
                        Home
                     </a>
                  </li>
                  <li id="tentang-kami-link"
                     class="<?= (strpos($currentUri, '#tentang_kami') !== false) ? 'active' : '' ?>">
                     <a href="#tentang_kami" style="color: black;">
                        Tentang Kami
                     </a>
                  </li>
                  <li id="bantuan-link" class="<?= (strpos($currentUri, 'bantuan') !== false) ? 'active' : '' ?>">
                     <a href="bantuan">
                        Bantuan
                     </a>
                  </li>
                  <li id="kontak-link" class="<?= (strpos($currentUri, '#kontak') !== false) ? 'active' : '' ?>">
                     <a href="#kontak" style="color: black;">
                        Kontak
                     </a>
                  </li>
                  <li id="login-link" class="<?= (strpos($currentUri, 'login') !== false) ? 'active' : '' ?>">
                     <a href="../../berlangganan/login" style="color: black;">
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

   <style>
      .cards-container {
         flex: 1;
         /* Memberikan ruang fleksibel untuk konten */
         display: flex;
         justify-content: center;
         align-items: center;
         gap: 20px;
         padding: 20px;
      }

      .card {
         background: #fff;
         border-radius: 10px;
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
         width: 300px;
         text-align: center;
         transition: transform 0.3s ease;
      }

      .card:hover {
         transform: scale(1.05);
      }

      .card .icon {
         font-size: 50px;
         color: #4CAF50;
         margin-top: 20px;
      }

      .card .title {
         font-size: 20px;
         font-weight: bold;
         margin: 15px 0;
      }

      .card .description {
         font-size: 16px;
         margin: 0 20px 20px;
      }

      .card a {
         text-decoration: none;
         display: block;
         background-color: #4CAF50;
         color: #fff;
         padding: 10px 20px;
         margin: 20px auto;
         width: 80%;
         border-radius: 5px;
      }

      #footer {
         margin-top: auto;
         background-color: #f8f8f8;
         padding: 20px 0;
         text-align: center;
      }
   </style>


   <div class="panjang" style="height: 70px; margin-top: 70px;"></div>
   <div class="cards-container">
      <div class="card">
         <i class="fas fa-users icon"></i>
         <div class="title">Keluarga Kurang Mampu</div>
         <div class="description">
            Data lengkap tentang keluarga kurang mampu.
         </div>
         <a href="kkm" class="btn btn-primary btn-scroll">
            Telusuri Layanan
         </a>
      </div>
      <div class="card">
         <i class="fas fa-hand-holding-heart icon"></i>
         <div class="title">Permohonan Bantuan</div>
         <div class="description">
            Informasi terkait permohonan bantuan yang diajukan.
         </div>
         <a href="permohonan_bantuan" class="btn btn-primary btn-scroll">
            Telusuri Layanan
         </a>
      </div>
   </div>

   <footer id="footer">
      <h3 class="section-title">Penutup</h3>
      <p>Copyright © <script>
            document.write(new Date().getFullYear());
         </script> Kantor Desa Noelbaki. Dibuat Oleh Elsa</p>
   </footer>

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
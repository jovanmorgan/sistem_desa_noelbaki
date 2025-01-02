<?php include 'nama_halaman.php'; ?>

<head>
    <meta charset="utf-8" />
    <link href="../../../assets/img/loding_donat.png" rel="icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link href="../../../assets/img/akademik/3.png" rel="icon" />
    <title>Data Export <?= $page_title ?> </title>
    <link rel="icon" type="image/png" href="../../../assets/img-umum/umum/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #4e73df;
            color: #fff;
            text-align: center;
            padding: 15px 20px;
            border-radius: 15px 15px 0 0;
        }

        .table thead th {
            background-color: #4e73df;
            color: #fff;
            text-transform: uppercase;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .dt-buttons button {
            border-radius: 5px;
            background-color: #4e73df;
            color: white;
            margin-right: 5px;
        }

        .dt-buttons button:hover {
            background-color: #375a7f;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for page Data Tables -->
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <style>
        .petakHov:hover {
            background-color: white;
        }

        .scroll {
            clear: both;
            border: 0px solid 3FF6600;
            max-height: 110px;
            overflow: auto;
            float: left;
            width: 100%;
        }

        .tooltip-inner {
            background-color: rgba(9, 9, 9, .6);
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #737373;
        }

        .zoom {
            transition: transform .2s;
            width: 100%;
            max-width: 90px;
            height: 50px;
            border-radius: 3px;
            margin: 0 auto;
        }

        .zoom:hover {
            width: 100%;
            max-width: 120px;
            border-radius: 0px;
            height: auto;
            -ms-transform: scale(2.9);
            /* IE 9 */
            -webkit-transform: scale(2.9);
            /* Safari 3-8 */
            transform: scale(2.9);
            margin-left: -35px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
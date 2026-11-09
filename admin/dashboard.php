<?php
session_start();

if(!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$total_pesanan = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM produksi")
);

$total_proses = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM produksi
    WHERE status='Sedang Dikerjakan'")
);

$total_selesai = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM produksi
    WHERE status='Produk Telah Selesai Dikerjakan'")
);


$total_antrian = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM produksi
    WHERE status='Dalam Antrian'")
);

?>


<!DOCTYPE html>
<html>

        <head>

            <title>Dashboard Admin</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

            <link rel="stylesheet" href="../css/style.css">

            <style>

        body{
            background: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }

        .navbar{
            background: #0f172a;
            padding: 18px 0;
        }

        .navbar-brand{
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .navbar-subtitle{
            color: #cbd5e1;
            font-size: 14px;
            margin-top: 3px;
        }

        .logout-btn{
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .main-content{
            padding: 50px 0;
            max-width: 1400px;
        }

        .dashboard-title{
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #1e293b;
            text-align: center;
        }

        .dashboard-card{
            border-radius: 24px;
            padding: 45px 35px;
            color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .dashboard-card:hover{
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(0,0,0,0.12);
        }

        .dashboard-card h3{
            font-size: 18px;
            margin-bottom: 18px;
            font-weight: 500;
            opacity: 0.9;
        }

        .dashboard-card h2{
            font-size: 52px;
            font-weight: 700;
        }

        .bg-blue{
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .bg-yellow{
            background: linear-gradient(135deg, #facc15, #eab308);
        }

        .bg-green{
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .bg-orange{
            background: linear-gradient(135deg, #ea580c, #c2410c);
        }

        .menu-box{
            margin-top: 50px;
            text-align: center;
        }

        .btn-menu{
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            color: white;
            margin: 8px;
            font-weight: 500;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-menu:hover{
            transform: translateY(-2px);
            opacity: 0.9;
            color: white;
        }

        .btn-blue{
            background: #2563eb;
        }

        .btn-green{
            background: #16a34a;
        }

        .btn-dark{
            background: #1e293b;
        }



        </style>
    </head>

    <body>

        <!-- Sidebar -->
    <div class="sidebar">

        <img src="../img/logo.png" class="logo">

        <div class="logo-text">
            CV Jaya Abadi
        </div>

        <a href="dashboard.php" class="active">
            Dashboard
        </a>

        <a href="tampil.php">
            Data Produksi
        </a>

        <a href="selesai_data.php">
            Produksi Selesai
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

    <div class="main">

    <div class="topbar">

        <h3>Dashboard Produksi</h3>

    </div>

    <div class="card-box">


        <div class="row g-4">

            <div class="col-md-3">
                <div class="dashboard-card bg-blue">
                    <h3> Total Pesanan</h3>
                    <h2><?= $total_pesanan; ?></h2>

                </div>
            </div>

            <div class="col-md-3">

                <div class="dashboard-card bg-yellow">

                    <h3>Sedang Dikerjakan</h3>
                     <h2><?= $total_proses; ?></h2>

                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card bg-green">
                    <h3>Produksi Selesai</h3>
                    <h2><?= $total_selesai; ?></h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card bg-orange">
                    <h3>Antrian Produksi</h3>
                    <h2><?= $total_antrian; ?></h2>
                </div>
            </div>
        </div>



    </div>

</body>
</html>
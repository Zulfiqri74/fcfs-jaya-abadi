<?php
include 'koneksi.php';

$data = null;
$error = "";

if(isset($_POST['cek'])){

    $nomor = $_POST['nomor_pesanan'];

    $query = mysqli_query($conn,
    "SELECT * FROM produksi
    WHERE nomor_pesanan='$nomor'");

    $data = mysqli_fetch_array($query);

    if(!$data){
        $error = "Nomor pesanan tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Cek Status Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

    body{
        background: #eef2f7;
        font-family: 'Poppins', sans-serif;
    }

    .box{
        width: 700px;
        margin: 60px auto;
    }

    .card-custom{
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .title{
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #0f172a;
        text-align: center;
    }

    .btn-custom{
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-custom:hover{
        background: #1d4ed8;
    }

    .status{
        padding: 10px 18px;
        border-radius: 12px;
        color: white;
        display: inline-block;
        font-weight: 600;
    }

    .menunggu{
        background: #facc15;
        color: black;
    }

    .proses{
        background: #0ea5e9;
    }

    .selesai{
        background: #16a34a;
    }

    </style>

</head>

<body>

<div class="box">

    <div class="card-custom">

        <div class="title">
            Cek Status Pesanan
        </div>

        <form method="POST">

            <div class="mb-3">

                <label>Masukkan Nomor Pesanan</label>

                <input type="text"
                name="nomor_pesanan"
                class="form-control"
                placeholder="Contoh: ORD1748458291"
                required>

            </div>

            <button type="submit"
            name="cek"
            class="btn-custom">

                Cek Status

            </button>

            <a href="index.php"
            class="btn btn-dark">

                Kembali

            </a>

        </form>

<?php if($error != "") { ?>

<div class="alert alert-danger mt-4 text-center">

    <strong>Nomor Pesanan Tidak Ditemukan!</strong><br>
    Silahkan periksa kembali nomor pesanan yang Anda masukkan.

</div>

<?php } ?>
</div>

<?php if($data) { ?>

    <div class="card-custom mt-4">

        <h4 class="mb-4">
            Detail Pesanan
        </h4>

        <table class="table">

            <tr>
                <td><b>Nomor Pesanan</b></td>
                <td><?= $data['nomor_pesanan']; ?></td>
            </tr>

            <tr>
                <td><b>Nama Pelanggan</b></td>
                <td><?= $data['nama_pelanggan']; ?></td>
            </tr>

            <tr>
                <td><b>Nama Produk</b></td>
                <td><?= $data['nama_pesanan']; ?></td>
            </tr>

            <tr>
                <td><b>Tanggal Masuk</b></td>
                <td>
                    <?= date('d-m-Y', strtotime($data['tanggal_masuk'])); ?>
                </td>
            </tr>

            <tr>
                <td><b>Estimasi</b></td>
                <td><?= $data['estimasi_hari']; ?> Hari</td>
            </tr>

            <tr>
                <td><b>Estimasi Selesai</b></td>
                <td>
                    <?= date('d-m-Y', strtotime($data['waktu_selesai'])); ?>
                </td>
            </tr>

            <tr>
                <td><b>Status</b></td>
                <td>

                <?php

                if($data['status'] == 'Dalam Antrian'){

                    echo "<span class='status menunggu'>Pesanan Anda Sedang Dalam Antrian</span>";

                }elseif($data['status'] == 'Sedang Dikerjakan'){

                    echo "<span class='status proses'>Sedang Dikerjakan</span>";

                }else{

                    echo "<span class='status selesai'>Produksi Selesai</span>";
                }

                ?>

                </td>
            </tr>

        </table>

    </div>

<?php } ?>

</div>

</body>
</html>
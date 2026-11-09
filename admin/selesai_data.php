<?php
session_start();

if(!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

?>

<!DOCTYPE html>
<html>
<head>

    <title>Data Produksi Selesai</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">

    <img src="../img/logo.png" class="logo">

    <div class="logo-text">
        CV Jaya Abadi
    </div>

    <a href="dashboard.php">
        Dashboard
    </a>

    <a href="tampil.php">
        Data Produksi
    </a>

    <a href="selesai_data.php" class="active">
        Produksi Selesai
    </a>

    <a href="logout.php">
        Logout
    </a>

</div>

<!-- Main -->
<div class="main">

    <!-- Topbar -->
    <div class="topbar">

        <h3>Data Produksi Selesai</h3>

    </div>

    <!-- Card -->
    <div class="card-box">

        <div class="d-flex justify-content-end mb-4">

            <form id="formSearch" method="GET" class="d-flex gap-2">

            <input
                type="text"
                name="search"
                class="form-control"
                style="width:280px;"
                placeholder="Cari No Order / Pelanggan / Pesanan..."
                value="<?= $search; ?>"
                onkeyup="autoSearch()">

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="selesai_data.php" class="btn btn-secondary">
                    Reset
                </a>

            </form>

        </div>

        <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>No</th>
                    <th>No Order</th>
                    <th>Nama Pelanggan</th>
                    <th>No Telepon</th>
                    <th>Nama Pesanan</th>
                    <th>Tanggal Masuk</th>
                    <th>Estimasi</th>
                    <th>Estimasi Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $no = 1;

            $data = mysqli_query($conn,

            "SELECT * FROM produksi
            WHERE status='Produk Telah Selesai Dikerjakan'
            AND
            (
                nomor_pesanan LIKE '%$search%'
                OR nama_pelanggan LIKE '%$search%'
                OR nama_pesanan LIKE '%$search%'
            )
            ORDER BY tanggal_masuk ASC"

            );

            while ($d = mysqli_fetch_array($data)) {

            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <b><?= $d['nomor_pesanan']; ?></b>
                    </td>

                    <td><?= $d['nama_pelanggan']; ?></td>

                    <td><?= $d['no_telepon']; ?></td>

                    <td><?= $d['nama_pesanan']; ?></td>

                    <td>
                        <?= date('d-m-Y', strtotime($d['tanggal_masuk'])); ?>
                    </td>

                    <td>
                        <?= $d['estimasi_hari']; ?> Hari
                    </td>

                    <td>
                        <?= date('d-m-Y', strtotime($d['waktu_selesai'])); ?>
                    </td>

                    <td>

                        <span class="badge-selesai">
                            Produksi Selesai
                        </span>

                    </td>

                    <td>

                        <a
                        class="btn btn-danger btn-sm"
                        href="hapus_selesai.php?id=<?= $d['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

        </div>

    </div>

</div>

<script>
let timer;

function autoSearch() {
    clearTimeout(timer);

    timer = setTimeout(function () {
        document.getElementById('formSearch').submit();
    }, 500);
}
</script>

</body>
</html>
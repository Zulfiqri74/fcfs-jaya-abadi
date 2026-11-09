<?php
session_start();

if(!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$success = false;

if (isset($_POST['simpan'])) {

    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_telepon = $_POST['no_telepon'];
    $nama_pesanan = $_POST['nama_pesanan'];
    $tanggal_masuk = date('Y-m-d H:i:s');

    // Ambil data produk
    $query_produk = mysqli_query($conn,
    "SELECT * FROM produk WHERE nama_produk='$nama_pesanan'");
    $produk = mysqli_fetch_array($query_produk);
    $estimasi_hari = $produk['estimasi_hari'];

    // Ambil antrian terakhir
    $cek = mysqli_query($conn,
    "SELECT * FROM produksi ORDER BY waktu_selesai DESC LIMIT 1");

    if (mysqli_num_rows($cek) > 0) {

        $last = mysqli_fetch_array($cek);

        $waktu_mulai = $last['waktu_selesai'];

    } else {

        $waktu_mulai = $tanggal_masuk;
    }

    // Hitung waktu selesai
    $waktu_selesai = date(
        'Y-m-d H:i:s',
        strtotime($waktu_mulai . " +$estimasi_hari days")
    );

    $cek_status = mysqli_query($conn,

    "SELECT * FROM produksi
    WHERE status='Sedang Dikerjakan'"

    );

    /* ==========================
    GENERATE NOMOR ORDER
    ========================== */

    $cek_order = mysqli_query($conn,

    "SELECT nomor_pesanan
    FROM produksi
    ORDER BY id DESC
    LIMIT 1"

    );

    if(mysqli_num_rows($cek_order) > 0){

        $last = mysqli_fetch_assoc($cek_order);

        $last_number = (int) substr(
            $last['nomor_pesanan'],
            3
        );

        $new_number = $last_number + 1;

    }else{

        $new_number = 1;
    }

    $nomor_pesanan = "ORD" .
    str_pad($new_number, 4, "0", STR_PAD_LEFT);

    /* ==========================
    STATUS PRODUKSI
    ========================== */

    if(mysqli_num_rows($cek_status) > 0){

        $status = "Dalam Antrian";

    }else{

        $status = "Sedang Dikerjakan";
    }

    mysqli_query($conn, "INSERT INTO produksi
(
    nomor_pesanan,
    nama_pelanggan,
    no_telepon,
    nama_pesanan,
    estimasi_hari,
    tanggal_masuk,
    waktu_mulai,
    waktu_selesai,
    status
)

VALUES
(
    '$nomor_pesanan',
    '$nama_pelanggan',
    '$no_telepon',
    '$nama_pesanan',
    '$estimasi_hari',
    '$tanggal_masuk',
    '$waktu_mulai',
    '$waktu_selesai',
    '$status'
)
");

    $success = true;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Input Pesanan FCFS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<?php if($success == true) { ?>

<script>

Swal.fire({
    icon: 'success',
    title: 'Pesanan Berhasil Dibuat',
    html: `
    <p>Silakan simpan nomor pesanan berikut:</p>

    <div style="
        font-size:22px;
        font-weight:bold;
        color:#2563eb;
        margin-top:10px;
    ">
        <?= $nomor_pesanan; ?>
    </div>
    `,
    confirmButtonText: 'OK'
});

</script>

<?php } ?>

<!-- Sidebar -->
<div class="sidebar">

    <img src="img/logo.png" class="logo">

    <div class="logo-text">
        CV Jaya Abadi
    </div>

<a href="index.php">Input Pesanan</a>

</div>

<!-- Main -->
<div class="main">

    <!-- Topbar -->
<div class="topbar">

    <div>

        <h3 style="margin-bottom:5px;">
            Pemesanan Produksi
        </h3>

        <small style="color:#64748b;">
            Sistem Penjadwalan Produksi Metode FCFS
        </small>

    </div>

    <div>

        <a href="cek_pesanan.php"
        class="btn btn-primary">

            Cek Status

        </a>

        <a href="admin/login.php"
        class="btn btn-dark">

            Login Admin

        </a>

    </div>

</div>

    <!-- Card -->
    <div class="card-box">

        <h4>Form Pemesanan</h4>

        <form method="POST">

            <div class="mb-3">

                <label>Nama Pelanggan</label>

                <input type="text"
                name="nama_pelanggan"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Nomor Telepon</label>

                <input type="text"
                name="no_telepon"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Pilih Produk</label>

                <select name="nama_pesanan"
                class="form-select"
                required>

                    <option value="">
                        -- Pilih Produk --
                    </option>

                    <?php

                    $produk = mysqli_query($conn,
                    "SELECT * FROM produk");

                    while ($p = mysqli_fetch_array($produk)) {

                        echo "
                        <option value='$p[nama_produk]'>

                        $p[nama_produk]
                        - $p[estimasi_hari] Hari

                        </option>
                        ";
                    }

                    ?>

                </select>

            </div>

            <button type="submit"
            name="simpan"
            class="btn-custom">

                Simpan Pesanan

            </button>

        </form>

    </div>

</div>

</body>
</html>
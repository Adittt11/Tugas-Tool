<?php
require "koneksi.php";

// Cek apakah parameter nama produk ada pada URL
if (!isset($_GET['nama'])) {
    header("Location: index.php"); // Redirect ke halaman utama jika tidak ada parameter nama
    exit();
}

$namaProduk = $_GET['nama'];

$queryDetailProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail,ketersediaan_stok FROM produk WHERE nama = '$namaProduk'");
$detailProduk = mysqli_fetch_assoc($queryDetailProduk);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Produk - <?php echo $detailProduk['nama']; ?></title>
    <!-- Tambahkan link ke file Bootstrap CSS di sini -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Navigasi -->
    <?php require "navbar.php" ?>

    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Detail Produk</h1>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="container mt-4 py-4">
        <div class="row">
            <div class="col-md-6">
                <img src="image/<?php echo $detailProduk['foto']; ?>" class="img-fluid" alt="<?php echo $detailProduk['nama']; ?>">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3"><?php echo $detailProduk['nama']; ?></h2>
                <p class="mb-4"><?php echo $detailProduk['detail']; ?></p>
                <p class="mb-2">Harga: Rp.<?php echo $detailProduk['harga']; ?></p>
                <p class="mb-2">Stok: <?php echo $detailProduk['ketersediaan_stok']; ?></p>
                <a href="index.php" class="btn btn-outline-info">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Tambahkan link ke file Bootstrap JS di sini -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
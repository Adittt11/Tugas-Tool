<?php
require "koneksi.php";
$queryProduk = mysqli_query($con, "SELECT id,nama,harga,foto,detail FROM produk");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Toko Online</title>
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
            <h1>Toko Online</h1>
            <h3>Mau Cari Apa?</h3>

        </div>
    </div>
    <!-- Konten utama -->
    <div class="container mt-4 py-4">
        <!-- Kotak Pencarian -->

        <h2 class="mb-5 text-center fw-bold">Produk Kami</h2>
        <div class="row">
            <!-- Produk 1 -->
            <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-md-4">
                    <div class="card text-center">
                        <img src="image/<?php echo $data['foto'] ?>" class="card-img-top" alt="Produk 1">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['nama'] ?></h5>
                            <p class="card-text"><?php echo $data['detail'] ?></p>
                            <p class="card-text">Harga: Rp.<?php echo $data['harga'] ?></p>
                            <a href="produk.php?nama=<?php echo $data['nama'] ?>" class="btn btn-info text-white">Lihat Detail </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!--  -->
    </div>

    <!-- Tambahkan link ke file Bootstrap JS di sini -->

    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
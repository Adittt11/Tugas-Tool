<?php
require "session.php";
require "../koneksi.php";

$queryProduk = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id =b.id");
$jumlahProduk = mysqli_num_rows($queryProduk);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

    <title>Produk</title>
</head>
<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php" ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama" class="mb-2 mt-2">Nama :</label>
                    <input type="text" id="nama" name="nama" placeholder="Input nama Produk" class="form-control" autocomplete=off required>
                </div>
                <div>
                    <label for="kategori" class="mb-2 mt-2">Kategori :</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga" class="mb-2 mt-2">Harga :</label>
                    <input type="number" id="harga" name="harga" placeholder="Input Harga" class="form-control" autocomplete=off required>
                </div>
                <div>
                    <label for="foto" class="mb-2 mt-2">Foto :</label>
                    <input type="file" id="foto" name="foto" class="form-control">
                </div>
                <div>
                    <label for="detail" class="mb-2 mt-2">Detail :</label>
                    <textarea id="detail" name="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok" class="mb-2 mt-2">Ketersediaan Stok :</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia">Tesedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </form>


            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $newname = $random_name . "." . $imageFileType;

                $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama = '$kategori'");
                $jumlahKategoriBaru = mysqli_num_rows($queryExist);
                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-warning mt-3">Nama, kategori, dan harga wajib diisi!</div>
                    <?php
                } else {
                    if ($nama_file != null) {
                        if ($image_size > 5242880) {
                    ?>
                            <div class="alert alert-warning mt-3">File tidak boleh lebih dari 5Mb</div>
                            <?php
                        } else {
                            if (($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif')) {
                            ?>
                                <div class="alert alert-warning mt-3">File Wajib bertibe jpg / png / gif</div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $newname);
                                $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto,detail,ketersediaan_stok) VALUES ('$kategori','$nama','$harga','$newname','$detail','$ketersediaan_stok')");
                                if ($queryTambah) {
                                ?>
                                    <div class="alert alert-success mt-3">Produk berhasil tersimpan!</div>
                                    <meta http-equiv="refresh" content="2; url=produk.php">
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-warning mt-3"><?php echo mysqli_error($con); ?></div>
                            <?php
                                }
                            }
                        }
                    } else {
                        $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto,detail,ketersediaan_stok) VALUES ('$kategori','$nama','$harga','','$detail','$ketersediaan_stok')");
                        if ($queryTambah) {
                            ?>
                            <div class="alert alert-success mt-3">Produk berhasil tersimpan!</div>
                            <meta http-equiv="refresh" content="2; url=produk.php">
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-warning mt-3"><?php echo mysqli_error($con); ?></div>
            <?php
                        }
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Produk</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama.</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Ketersediaan Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Data Kategori tidak tersedia</td>
                            </tr>
                            <?php

                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($queryProduk)) {
                            ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['kategori_id']; ?></td>
                                    <td><?php echo $data['harga']; ?></td>
                                    <td><?php echo $data['ketersediaan_stok']; ?></td>
                                    <td><a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a></td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
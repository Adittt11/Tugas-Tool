<?php
require "session.php";
require "../koneksi.php";
$id = $_GET['p'];
$query = mysqli_query($con, "SELECT * FROM kategori WHERE id = '$id'");
$data = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

    <title>Detail Kategori</title>
</head>


<body>
    <?php require "navbar.php" ?>
    <div class="container mt-5">


        <h2>Detail Kategori</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori" class="mb-2">Kategori :</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit" name="editBtn">Edit</button>
                    <button class="btn btn-danger" type="submit" name="deleteBtn">Delete</button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['editBtn'])) {
            $kategori = htmlspecialchars($_POST['kategori']);
            if ($data['nama'] == $kategori) {
        ?>
                <meta http-equiv="refresh" content="0; url=kategori.php">
                <?php
            } else {
                $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                $jumlahdata = mysqli_num_rows($query);
                if ($jumlahdata > 0) {
                ?>
                    <div class="alert alert-warning mt-3">Kategori sudah tersedia!</div>
                    <?php
                } else {
                    $querySimpan = mysqli_query($con, "UPDATE kategori SET nama = '$kategori' WHERE id='$id'");
                    if ($querySimpan) {
                    ?>
                        <div class="alert alert-success mt-3">Kategori berhasil diupdate!</div>
                        <meta http-equiv="refresh" content="2; url=kategori.php">
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-warning mt-3"><?php echo mysqli_error($con); ?></div>
                <?php

                    }
                }
            }
        }
        if (isset($_POST['deleteBtn'])) {
            $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
            $check = mysqli_num_rows($queryCheck);
            if ($check > 0) {
                ?>
                <div class="alert alert-warning mt-3">Kategori tidak dihapus karena sudah digunakan di produk</div>
            <?php
                die();
            }
            $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
            $check = mysqli_num_rows($queryCheck);
            if ($check > 0) {
            ?>
                <div class="alert alert-warning mt-3">Kategori tidak dihapus karena sudah digunakan di produk</div>
            <?php
                die();
            }
            $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
            if ($queryDelete) {
            ?>
                <div class="alert alert-success mt-3">Kategori berhasil dihapus!</div>
                <meta http-equiv="refresh" content="2; url=kategori.php">
        <?php
            }
        }

        ?>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
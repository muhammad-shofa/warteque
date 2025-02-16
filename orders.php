<?php
include "service/connection.php";
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Warteque</title>
</head>

<body class="bg-light">
    <div class="container-xl bg-light p-4 bg-warning">
        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <!-- menu makanan start -->
        <div class="menu-makanan my-5 d-flex justify-content-center flex-wrap gap-5">
            <?php if ($results_menu->num_rows > 0) { ?>
                <?php while ($data_menu = $results_menu->fetch_assoc()) { ?>
                    <div class="card" style="width: 250px;">
                        <img src="assets/img/uploads/<?= $data_menu['gambar'] ?>" class="card-img-top" alt="Menu Img"
                            width="250px" height="250px">
                        <div class="card-body">
                            <h5 class="card-title"><?= $data_menu['nama_makanan'] ?></h5>
                            <p class="card-text"><?= $data_menu['deskripsi'] ?></p>
                            <p class="fw-bold">Rp <?= $data_menu['harga'] ?></p>
                            <button class="btn btn-primary select-btn" data-menu-id="<?= $data_menu['menu_id'] ?>"
                                data-nama="<?= $data_menu['nama_makanan'] ?>"
                                data-harga="<?= $data_menu['harga'] ?>">Select</button>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <!-- menu makanan end -->

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "service/ajax/ajax-pesanan.php",
                    data: {
                        user_id: user_id
                    }
                })
            });
        </script>

</body>

</html>
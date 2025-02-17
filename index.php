<?php
include "service/connection.php";
session_start();

$sql_get_menu = "SELECT * FROM menu";
$results_menu = $connected->query($sql_get_menu);

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

        <!-- Modal Order Start -->
        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Order Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-menu-name"></p>
                        <input type="hidden" id="modal-menu-id">
                        <input type="hidden" id="modal-user-id" value="<?= $_SESSION['user_id'] ?>">
                        <input type="hidden" id="modal-menu-harga">
                        <label for="modal-jumlah">Jumlah:</label>
                        <input type="number" id="modal-jumlah" class="form-control" min="1" value="1">
                        <p class="mt-2">Total Harga: <span id="modal-total-harga">Rp 0</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="orderNow">Order Now</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Order End -->

        <!-- Modal Status Order Start -->
        <div class="modal fade" id="statusOrderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Status Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="textStatusOrder"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Status Order End -->

        <!-- footer start -->
        <footer class="d-flex bg-dark text-white flex-wrap justify-content-center">
            <div class="footer-warteque">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo laudantium incidunt assumenda est cum, cumque esse praesentium deleniti itaque quam perspiciatis omnis doloribus expedita maiores placeat eum. Architecto, impedit ducimus!</p>
            </div>

            

        </footer>
        <!-- footer end -->

        <script>
            $(document).ready(function() {

                // ketika button dengan class .select-btn diklik maka akan ambil data dari atribut tertentu dan ditampilkan pada modal
                $(".select-btn").click(function() {
                    let menu_id = $(this).data("menu-id");
                    let nama = $(this).data("nama");
                    let harga = $(this).data("harga");

                    $("#modal-menu-id").val(menu_id);
                    $("#modal-jumlah").val("1");
                    $("#modal-menu-harga").val(harga);
                    $("#modal-menu-name").text(nama);

                    // let totalHargaDef = 1 * harga;

                    $("#modal-total-harga").text("Rp " + harga);
                    $("#orderModal").modal("show");
                });

                // ketik ada perubahan pada inputan jumlah, maka akan mengkalkulasikannya secara otomatis
                $("#modal-jumlah").on("input", function() {
                    let harga = parseInt($("#modal-menu-harga").val());
                    let jumlah = parseInt($(this).val()) || 1;
                    let totalHarga = jumlah * harga;
                    $("#modal-total-harga").text("Rp " + totalHarga);
                });

                // ketika tombol order now pada modal diklik maka kan mengirim data ke backend untuk dimasukkan kedalam database
                $("#orderNow").click(function() {
                    let menu_id = $("#modal-menu-id").val();
                    let user_id = $("#modal-user-id").val();
                    let harga = parseInt($("#modal-menu-harga").val());
                    let jumlah = parseInt($("#modal-jumlah").val());
                    let totalHarga = jumlah * harga;

                    $.ajax({
                        url: "service/ajax/ajax-pesanan.php",
                        type: "POST",
                        data: {
                            menu_id: menu_id,
                            user_id: user_id,
                            jumlah: jumlah,
                            total_harga: totalHarga
                        },
                        success: function(response) {
                            let data = JSON.parse(response);
                            if (data.success) {
                                // alert("Your orders successfull! Total: Rp " + totalHarga);
                                $("#orderModal").modal("hide");
                                $("#textStatusOrder").text("Your order has been noted by the chef! Total: Rp " + totalHarga);
                                $("#statusOrderModal").modal("show");
                            } else {
                                $("#textStatusOrder").text("Order failed! please try again later");
                                $("#statusOrderModal").modal("show");
                                // alert("Gagal memesan. Coba lagi!");
                            }
                        }
                    });
                });
            });
        </script>

</body>

</html>
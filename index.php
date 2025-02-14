<?php
include "service/connection.php";

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

<body>
    <div class="container-xl bg-light p-4 bg-warning">
        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <!-- menu makanan start -->
        <div class="menu-makanan d-flex justify-content-center flex-wrap">
            <?php if ($results_menu->num_rows > 0) { ?>
                <?php while ($data_menu = $results_menu->fetch_assoc()) { ?>
                    <div class="col-md-4">
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
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <!-- menu makanan end -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Order Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-menu-name"></p>
                        <input type="hidden" id="modal-menu-id">
                        <input type="hidden" id="modal-menu-harga">
                        <label for="modal-jumlah">Jumlah:</label>
                        <input type="number" id="modal-jumlah" class="form-control" min="1" value="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="orderNow">Order Now</button>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Modal -->
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

        <script>
            $(document).ready(function () {
                $(".select-btn").click(function () {
                    let menuId = $(this).data("menu-id");
                    let nama = $(this).data("nama");
                    let harga = $(this).data("harga");

                    $("#modal-menu-id").val(menuId);
                    $("#modal-menu-harga").val(harga);
                    $("#modal-menu-name").text(nama);

                    // let totalHargaDef = 1 * harga;

                    $("#modal-total-harga").text("Rp " + harga);
                    $("#orderModal").modal("show");
                });

                $("#modal-jumlah").on("input", function () {
                    let harga = parseInt($("#modal-menu-harga").val());
                    let jumlah = parseInt($(this).val()) || 1;
                    let totalHarga = jumlah * harga;
                    $("#modal-total-harga").text("Rp " + totalHarga);
                });

                $("#orderNow").click(function () {
                    let menuId = $("#modal-menu-id").val();
                    let harga = parseInt($("#modal-menu-harga").val());
                    let jumlah = parseInt($("#modal-jumlah").val());
                    let totalHarga = jumlah * harga;
                    let userId = 1; // Gantilah dengan ID user yang login

                    $.ajax({
                        url: "service/ajax/ajax-pesanan.php",
                        type: "POST",
                        data: {
                            menu_id: menuId,
                            user_id: userId,
                            jumlah: jumlah,
                            total_harga: totalHarga
                        },
                        success: function (response) {
                            let data = JSON.parse(response);
                            if (data.success) {
                                alert("Pesanan berhasil! Total: Rp " + totalHarga);
                                $("#orderModal").modal("hide");
                            } else {
                                alert("Gagal memesan. Coba lagi!");
                            }
                        }
                    });
                });
            });
        </script>


        <!-- Modal select menu start -->
        <!-- <div class="modal fade" id="modalSelect">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h4 class="modal-title">Select Menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formPesanan" method="POST">
                        <h1>Judul</h1>
                </form>
                </div>
            </div>
        </div> -->
        <!-- Modal select menu End -->

        <!-- <script>
            $(document).ready(function () {

                $(".select-btn").click(function () {
                    let menuId = $(this).data("menu-id");
                    let nama = $(this).data("nama");
                    let harga = $(this).data("harga");

                    $("#modal-menu-id").val(menuId);
                    $("#modal-menu-harga").val(harga);
                    $("#modal-menu-name").text(nama);
                    $("#modalSelect").modal("show");
                });

                $("#orderNow").click(function () {
                    let menuId = $("#modal-menu-id").val();
                    let harga = parseInt($("#modal-menu-harga").val());
                    let jumlah = parseInt($("#modal-jumlah").val());
                    let totalHarga = jumlah * harga;
                    let userId = 1; // Gantilah dengan ID user yang login

                    $.ajax({
                        url: "service/ajax/ajax-pesanan.php",
                        type: "POST",
                        data: {
                            menu_id: menuId,
                            user_id: userId,
                            jumlah: jumlah,
                            total_harga: totalHarga
                        },
                        success: function (response) {
                            let data = JSON.parse(response);
                            if (data.success) {
                                alert("Pesanan berhasil! Total: Rp " + totalHarga);
                                $("#orderModal").modal("hide");
                            } else {
                                alert("Gagal memesan. Coba lagi!");
                            }
                        }
                    })
                })
            })
        </script> -->

</body>

</html>
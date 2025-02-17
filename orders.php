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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Warteque</title>
</head>

<body class="bg-light">
    <div class="container-xl bg-light p-4 bg-warning">
        <p id="user_id" class="text-dark d-none"><?= $_SESSION['user_id'] ?? "" ?></p>

        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <div class="container mt-4">
            <h4 class="mb-3">Your Orders List</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Makanan</th>
                            <th>Gambar</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="list-pesanan">
                        <!-- Data pesanan -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal konfirmasi hapus start -->
        <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Confirm delete Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this order?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete" data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal konfirmasi hapus end -->



        <script>
            $(document).ready(function() {
                let user_id = $("#user_id").text();
                let selectedMenuId = null;
                let selectedUserId = null;
                console.log(user_id);

                if (user_id) {
                    $.ajax({
                        url: "service/ajax/ajax-pesanan.php",
                        method: "POST",
                        data: {
                            show_order_user_id: user_id
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log("Response dari server:", response);
                            if (response.success) {
                                let orders = response.orders;
                                $("#list-pesanan").empty();

                                orders.forEach(function(item, index) {
                                    let pesananHTML = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.nama_makanan}</td>
                                        <td><img src="assets/img/uploads/${item.gambar}" class="img-fluid" width="50" alt="${item.gambar}"></td>
                                        <td>${item.jumlah}</td>
                                        <td>Rp ${item.harga.toLocaleString()}</td>
                                        <td>Rp ${item.total_harga.toLocaleString()}</td>
                                        <td><button class="btn btn-danger btn-delete-order" data-menu-id="${item.menu_id}">Delete</button></td>
                                        </tr>`;
                                    $("#list-pesanan").append(pesananHTML);
                                });
                            } else {
                                $("#list-pesanan").html(`<tr><td colspan="5" class="text-muted text-center">You have no orders yet.</td></tr>`);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                } else {
                    console.log("User ID tidak ditemukan!");
                }

                // Event listener untuk tombol delete 
                $(document).on("click", ".btn-delete-order", function() {
                    selectedMenuId = $(this).data("menu-id");
                    selectedUserId = $("#user_id").text();
                    $("#modalKonfirmasi").modal("show");
                });

                // Konfirmasi penghapusan
                $("#confirmDelete").click(function() {
                    if (selectedMenuId) {
                        $.ajax({
                            url: "service/ajax/ajax-pesanan.php",
                            method: "DELETE",
                            data: {
                                menu_id: selectedMenuId,
                                user_id: selectedUserId
                            },
                            success: function(response) {
                                $("#modalKonfirmasi").modal("hide");
                                loadOrders(); // Perbarui tabel pesanan tanpa reload halaman
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    }
                });

                // Fungsi untuk memuat ulang daftar pesanan
                function loadOrders() {
                    $.ajax({
                        url: "service/ajax/ajax-pesanan.php",
                        method: "POST",
                        data: {
                            show_order_user_id: user_id
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#list-pesanan").empty();
                            if (response.success) {
                                response.orders.forEach(function(item, index) {
                                    let pesananHTML = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama_makanan}</td>
                            <td><img src="assets/img/uploads/${item.gambar}" class="img-fluid" width="50" alt="${item.gambar}"></td>
                            <td>${item.jumlah}</td>
                            <td>Rp ${item.total_harga.toLocaleString()}</td>
                            <td><button class="btn btn-danger btn-delete-order" data-menu-id="${item.menu_id}">Delete</button></td>
                        </tr>`;
                                    $("#list-pesanan").append(pesananHTML);
                                });
                            } else {
                                $("#list-pesanan").html(`<tr><td colspan="6" class="text-muted text-center">You have no orders yet.</td></tr>`);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                }
            });
        </script>
    </div>
</body>

</html>
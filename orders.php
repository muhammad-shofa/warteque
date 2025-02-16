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
        <p id="user_id" class="text-dark d-none"><?= $_SESSION['user_id'] ?? "" ?></p>

        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <!--  -->
        <div class="container mt-4">
            <h4 class="mb-3">Your Orders List</h4>
            <div id="list-pesanan" class="row">
                <!-- Data pesanan akan dimasukkan di sini menggunakan jQuery -->
            </div>
        </div>
        <!--  -->

        <script>
            $(document).ready(function() {
                let user_id = $("#user_id").text();
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
                                $("#list-pesanan").empty(); // Bersihkan data sebelum menambahkan yang baru

                                orders.forEach(function(item) {
                                    let totalHarga = item.jumlah * item.harga; // Hitung total harga

                                    // <p class="card-text"><strong>Harga:</strong> Rp ${item.harga.toLocaleString()}</p>
                                    let pesananHTML = `
                                    <div class="col-md-4">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                            <h5 class="card-title">${item.nama_makanan}</h5>
                                            <img src="assets/img/uploads/${item.gambar}" class="card-img-top w-50" alt="${item.gambar}">
                                                <p class="card-text"><strong>Jumlah:</strong> ${item.jumlah}</p>
                                                <p class="card-text"><strong>Total Harga:</strong> Rp ${item.total_harga}</p>
                                            </div>
                                        </div>
                                    </div>`;

                                    $("#list-pesanan").append(pesananHTML);
                                });
                            } else {
                                $("#list-pesanan").html(`<p class="text-muted">You have no orders yet.</p>`);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                } else {
                    console.log("User ID tidak ditemukan!");
                }
            });
        </script>

</body>

</html>
<?php
session_start();

if ($_SESSION['is_login'] == false) {
    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Warteque | menu Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!--  -->
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar start -->
        <?php include "../components/sidebar.php" ?>
        <!-- sidebar end -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <!-- navbar start -->
            <?php include "../components/navbar-dashboard.php" ?>
            <!-- navbar end -->
               
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Menu Dashboard</h1>
                    </div>

                    <!-- btn trigger modal tambah menu -->
                    <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalTambah">
                        Add New Menu
                    </button>

                    <!-- menu table start -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Menu Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-dark" id="menuTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Food Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Picture</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal tambah menu start -->
                    <div class="modal fade" id="modalTambah">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Menu</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formTambah" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" id="tambah_menu_id" name="menu_id">
                                        <div class="form-group">
                                            <label for="tambah_nama_makanan">Food Name :</label>
                                            <input type="text" class="form-control" id="tambah_nama_makanan"
                                                name="nama_makanan">
                                        </div>

                                        <div class="form-floating">
                                            <label for="tambah_deskripsi">Description</label>
                                            <textarea class="form-control" name="deskripsi" id="tambah_deskripsi"
                                                style="height: 100px"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="tambah_harga">Price :</label>
                                            <input type="number" class="form-control" id="tambah_harga" name="harga">
                                        </div>

                                        <div class="form-group">
                                            <label for="tambah_gambar">Picture :</label>
                                            <input type="file" class="form-control" id="tambah_gambar" name="gambar"
                                                accept="image/*">
                                            <img id="preview_gambar" src="#" alt="Preview Image"
                                                style="max-width: 100%; height: auto; display: none;">
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-primary" name="simpanTambah"
                                            id="simpanTambah">Add</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Modal tambah menu End -->

                    <!-- Modal edit menu start -->
                    <div class="modal fade" id="modalEdit">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Menu</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formEdit" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" id="edit_menu_id" name="menu_id">
                                        <div class="form-group">
                                            <label for="edit_nama_makanan">Food Name :</label>
                                            <input type="text" class="form-control" id="edit_nama_makanan"
                                                name="nama_makanan">
                                        </div>

                                        <div class="form-floating">
                                            <label for="edit_deskripsi">Description</label>
                                            <textarea class="form-control" name="deskripsi" id="edit_deskripsi"
                                                style="height: 100px"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_harga">Price :</label>
                                            <input type="number" class="form-control" id="edit_harga" name="harga">
                                        </div>
                                        <!-- 
                                        <div class="form-group">
                                            <label for="edit_gambar">Picture :</label>
                                            <input type="file" class="form-control" id="edit_gambar" name="gambar"
                                                accept="image/*">
                                            <img id="preview_gambar" src="#" alt="Preview Image"
                                                style="max-width: 100%; height: auto; display: none;">
                                        </div> -->

                                        <div class="form-group">
                                            <label for="edit_gambar">Picture :</label>
                                            <input type="file" class="form-control" id="edit_gambar" name="gambar"
                                                accept="image/*">
                                            <img id="edit_preview_gambar_db" src="#" alt="Preview Image"
                                                style="max-width: 100%; height: auto; display: none; margin-top: 10px;">
                                            <img id="edit_preview_gambar_new" src="#" alt="Preview Image"
                                                style="max-width: 100%; height: auto; display: none; margin-top: 10px;">
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-success" name="simpanEdit"
                                            id="simpanEdit">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Modal edit menu end -->

                    <!-- menu table end -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- javascript -->
    <script>
        $(document).ready(function () {
            var menuTable = $('#menuTable').DataTable({
                "ajax": "../service/ajax/ajax-menu.php",
                "columns": [{
                    "data": "no"
                },
                {
                    "data": "nama_makanan"
                },
                {
                    "data": "deskripsi"
                },
                {
                    "data": "harga"
                },
                {
                    "data": "show_gambar"
                },
                {
                    "data": "action",
                    // "orderable": true,
                    // "searchable": true
                }
                ],
                "responsive": true,
                // paging: false
            });

            // Tambah menu
            $('#simpanTambah').click(function () {
                // var data = $('#formTambah').serialize();

                var formData = new FormData($('#formTambah')[0]);

                formData.append('simpanUpload', true);
                $.ajax({
                    url: '../service/ajax/ajax-menu.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#modalTambah').modal('hide');
                        $("#preview_gambar").attr("src", "#").show();
                        $("#preview_gambar").hide();
                        menuTable.ajax.reload();
                        $('#formTambah')[0].reset();
                        alert(response);
                    }
                });
            });

            // tampilkan preview ketika ada gambar yang akan diupload
            $("#tambah_gambar").change(function (event) {
                let input = this;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $("#preview_gambar").attr("src", e.target.result).show();
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            });

            // mengambil data untuk ditampilkan pada modal edit
            $('#menuTable').on('click', '.edit', function () {
                let menu_id = $(this).data('menu_id');
                $.ajax({
                    url: '../service/ajax/ajax-menu.php?menu_id=' + menu_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#edit_menu_id').val(data.menu_id);
                        $('#edit_nama_makanan').val(data.nama_makanan);
                        $('#edit_deskripsi').val(data.deskripsi);
                        $('#edit_harga').val(data.harga);

                        // Menampilkan gambar yang sudah ada di database
                        if (data.gambar) {
                            $('#edit_preview_gambar_db').attr('src', '../assets/img/uploads/' + data.gambar).show();
                        } else {
                            $('#edit_preview_gambar_db').hide();
                        }

                        $('#modalEdit').modal('show');
                    }
                });
            });

            // tampilkan preview ketika ada gambar yang akan diupload pada modal edit
            $('#edit_gambar').change(function (event) {
                let input = this;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $('#edit_preview_gambar_db').hide();

                        $('#edit_preview_gambar_new').attr('src', e.target.result).show();
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Menyimpan edit
            $('#simpanEdit').click(function () {
                // var data = $('#formEdit').serialize();
                var formData = new FormData($('#formEdit')[0]);

                // formData.append('simpanUpload', true);
                $.ajax({
                    url: '../service/ajax/ajax-menu.php?edit_menu=1',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#modalEdit').modal('hide');
                        menuTable.ajax.reload();
                        $('#formEdit')[0].reset();
                        alert(response);
                    }
                });
            });


            // hapus data sesuai id
            $('#menuTable').on('click', '.delete', function () {
                var menu_id = $(this).data('menu_id');
                if (confirm('Anda yakin ingin menghapus menu ini?')) {
                    $.ajax({
                        url: '../service/ajax/ajax-menu.php',
                        type: 'DELETE',
                        data: {
                            menu_id: menu_id
                        },
                        success: function (response) {
                            menuTable.ajax.reload();
                            alert(response);
                        }
                    });
                }
            });


        });
    </script>

</body>

</html>
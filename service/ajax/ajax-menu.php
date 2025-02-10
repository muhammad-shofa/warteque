<?php
include "../../service/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // users
    if (isset($_GET["menu_id"])) {
        $menu_id = $_GET["menu_id"];
        $stmt = $connection->prepare("SELECT * FROM menu WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        $stmt = $connection->prepare("SELECT * FROM menu");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $i++;
            $row['no'] = $i;

            // untuk memformat harga
            $row['harga'] = number_format($row['harga'], 0, ',', '.');

            $row['action'] = '<button type="button" class="edit btn btn-primary btn-sm" data-menu_id="' . $row['menu_id'] . '" data-toggle="modal"><i class="fas fa-pen"></i></button>
        <button type="button" class="delete btn btn-danger btn-sm" data-menu_id="' . $row['menu_id'] . '" data-toggle="modal"><i class="fas fa-trash"></i></button>';

            $data[] = $row;
        }

        echo json_encode(["data" => $data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama_makanan = htmlspecialchars($_POST["nama_makanan"]);
    $deskripsi = htmlspecialchars($_POST["deskripsi"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $gambar = $_FILES["gambar"];

    // 
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        // lokasi gambar
        $location = "../../assets/img/uploads/" . basename($gambar);

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($tmp, $location)) {
            $stmt = $connection->prepare("INSERT INTO menu (nama_makanan, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nama_makanan, $deskripsi, $harga, $gambar);

            if ($stmt->execute()) {
                echo "Berhasil menambahkan data baru";
            } else {
                echo "Gagal menambahkan data baru" . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Gagal mengunggah file.";
        }
    }



    // if ($stmt->execute()) {
    //     echo "Berhasil menambah tipe barang baru";
    // } else {
    //     echo "Gagal menambah tipe barang baru " . $stmt->error;
    // }

}

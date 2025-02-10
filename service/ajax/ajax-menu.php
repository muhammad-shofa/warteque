<?php
include "../../service/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // users
    if (isset($_GET["menu_id"])) {
        $menu_id = $_GET["menu_id"];
        $stmt = $connected->prepare("SELECT * FROM menu WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        $stmt = $connected->prepare("SELECT * FROM menu");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $i++;
            $row['no'] = $i;

            // untuk memformat harga
            $row['harga'] = number_format($row['harga'], 0, ',', '.');

            $row['show_gambar'] = '<img src="../assets/img/uploads/' . $row['gambar'] . '" alt="' . $row["gambar"] . '" width="150px"/>';

            $row['action'] = '<button type="button" class="edit btn btn-primary btn-sm" data-menu_id="' . $row['menu_id'] . '" data-toggle="modal"><i class="fas fa-pen"></i></button>
        <button type="button" class="delete btn btn-danger btn-sm" data-menu_id="' . $row['menu_id'] . '" data-toggle="modal"><i class="fas fa-trash"></i></button>';

            $data[] = $row;
        }

        echo json_encode(["data" => $data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_GET['edit_menu'])) {
        // parse_str(file_get_contents("php://input"), $data);
        $menu_id = $_POST["menu_id"]; // i
        $nama_makanan = $_POST["nama_makanan"]; // s
        $deskripsi = $_POST['deskripsi']; // s
        $harga = $_POST['harga']; // i
        $gambar = $_FILES['gambar'];

        // Periksa apakah ada file gambar yang diunggah
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];

            // Lokasi penyimpanan gambar baru
            $location = "../../assets/img/uploads/" . basename($gambar);

            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($tmp, $location)) {
                // Update data menu
                $stmt_w_img = $connected->prepare("UPDATE menu SET nama_makanan = ?, deskripsi = ?, harga = ?, gambar = ? WHERE menu_id = ?");
                $stmt_w_img->bind_param("ssisi", $nama_makanan, $deskripsi, $harga, $gambar, $menu_id);

                if ($stmt_w_img->execute()) {
                    echo "Berhasil menambahkan data baru";
                } else {
                    echo "Gagal menambahkan data baru" . $stmt_w_img->error;
                }

                $stmt_w_img->close();
            } else {
                echo "Gagal mengunggah file.";
                exit;
            }
        } else {
            // Update data menu
            $stmt = $connected->prepare("UPDATE menu SET nama_makanan = ?, deskripsi = ?, harga = ? WHERE menu_id = ?");
            $stmt->bind_param("ssii", $nama_makanan, $deskripsi, $harga, $menu_id);

            if ($stmt->execute()) {
                echo "Berhasil mengedit data menu";
            } else {
                echo "Gagal mengedit data menu: " . $stmt->error;
            }

            $stmt->close();
        }

    } else {
        $nama_makanan = htmlspecialchars($_POST["nama_makanan"]);
        $deskripsi = htmlspecialchars($_POST["deskripsi"]);
        $harga = htmlspecialchars($_POST["harga"]);
        $gambar = $_FILES["gambar"];

        // upload jika ada gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];

            // lokasi gambar
            $location = "../../assets/img/uploads/" . basename($gambar);

            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($tmp, $location)) {
                $stmt = $connected->prepare("INSERT INTO menu (nama_makanan, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
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
    }

} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Hapus barang 
    parse_str(file_get_contents("php://input"), $data);
    $menu_id = $data["menu_id"];

    $stmt = $connected->prepare("DELETE FROM menu WHERE menu_id = ?");
    $stmt->bind_param("i", $menu_id);

    if ($stmt->execute()) {
        echo "Berhasil menghapus menu";
    } else {
        echo "Gagal menghapus menu" . $stmt->error;
    }
}

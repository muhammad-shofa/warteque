<?php
session_start();
include '../connection.php'; // Pastikan file ini berisi koneksi ke database


// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $user_id = $_GET["user_id"];

//     $data = [];
//     $stmt_get_menu = $connected->prepare("SELECT * FROM pesanan WHERE user_id = ?");
//     $stmt_get_menu->bind_param("i", $user_id);
//     $stmt->execute();
//     $result = $stmt_get_menu->get_result();
//     // $data['success'] = true;
//     $data = $result->fetch_assoc();
//     echo json_encode($data);
// } else 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['show_order_user_id'])) {
        $user_id = htmlspecialchars($_POST['show_order_user_id']);

        // ambil pesanan sesuai user_id yang ada
        // $query = "SELECT * FROM pesanan WHERE user_id = ?";
        $query = "SELECT pesanan.*, menu.nama_makanan, menu.gambar, menu.harga
          FROM pesanan 
          INNER JOIN menu ON pesanan.menu_id = menu.menu_id 
          WHERE pesanan.user_id = ?";
        $stmt = $connected->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika ada pesanan, simpan dalam array
        if ($result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            echo json_encode(["success" => true, "orders" => $orders]);
        } else {
            echo json_encode(["success" => false, "message" => "You have no orders yet."]);
        }

        $stmt->close();
    } else {
        // masukkan order user ke table pesanan
        $menu_id = htmlspecialchars($_POST['menu_id']);
        $user_id = htmlspecialchars($_POST['user_id']);
        $jumlah = htmlspecialchars($_POST['jumlah']);
        $total_harga = htmlspecialchars($_POST['total_harga']);

        $stmt = $connected->prepare("INSERT INTO pesanan (user_id, menu_id, jumlah, total_harga) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $user_id, $menu_id, $jumlah, $total_harga);

        $response = [];
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }

        $stmt->close();

        echo json_encode($response);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $menu_id = $data["menu_id"];
    $user_id = $data["user_id"];
    // $user_id = 

    $stmt = $connected->prepare("DELETE FROM pesanan WHERE menu_id = ? && user_id = ?");
    $stmt->bind_param("ii", $menu_id, $user_id);

    if ($stmt->execute()) {
        echo "Berhasil menghapus menu";
    } else {
        echo "Gagal menghapus menu" . $stmt->error;
    }

    echo json_encode();
}

$connected->close();

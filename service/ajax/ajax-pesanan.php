<?php
session_start();
include '../connection.php'; // Pastikan file ini berisi koneksi ke database


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET["user_id"];

    $stmt_get_menu = $connected->prepare("SELECT * FROM pesanan WHERE user_id = ?");
    $stmt_get_menu->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt_get_menu->get_result();
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

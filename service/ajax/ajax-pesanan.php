<?php
session_start();
include '../connection.php'; // Pastikan file ini berisi koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = $_POST['menu_id'];
    $user_id = $_POST['user_id'];
    $jumlah = $_POST['jumlah'];
    $total_harga = $_POST['total_harga'];

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

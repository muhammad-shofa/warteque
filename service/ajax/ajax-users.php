<?php
include "../../service/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // users
    if (isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
        $stmt = $connected->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        $stmt = $connected->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $i++;
            $row['no'] = $i;

            // untuk memformat harga
            // $row['harga_satuan'] = number_format($row['harga_satuan'], 0, ',', '.');

            $row['action'] = '<button type="button" class="edit btn btn-primary btn-sm" data-user_id="' . $row['user_id'] . '" data-toggle="modal"><i class="fas fa-pen"></i></button>
        <button type="button" class="delete btn btn-danger btn-sm" data-user_id="' . $row['user_id'] . '" data-toggle="modal"><i class="fas fa-trash"></i></button>';

            $data[] = $row;
        }

        echo json_encode(["data" => $data]);
    }
}

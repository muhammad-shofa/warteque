<?php

include "service/connection.php";

$status_register = "";

// insert daftar
if (isset($_POST["register"])) {
    $name = htmlspecialchars($_POST["name"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $role = 'pelanggan';

    $hash_password = hash('sha256', $password);

    // Check is username alreacy used?
    // $stmt_check_username = "SELECT * FROM users WHERE username = ?";
    // $stmt_check_username->bind_param("s", $username);
    // $stmt_check_username->execute();
    // $result = $stmt_check_username->get_result();
    // $data = $result->fetch_assoc();
    // if ($result->num_rows > 0) {
    //     $status_register = "Username must be unique";
    //     exit();
    // }


    $stmt_regis = $connected->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt_regis->bind_param("ssss", $name, $username, $hash_password, $role);
    $result = $stmt_regis->execute();

    if ($result) {
        $status_register = "<b>Register successfully, let's <a href='login.php'>Login!</a></b>";
    } else {
        $status_register = "<b>Register failed, please try again!</a></b>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <title>Warteque | Register</title>
</head>

<body>

    <div class="container-lg bg-light mx-auto p-4">
        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <!-- form register start -->
        <div class="d-flex justify-content-center mt-5">
            <div class="w-50 mt-5">
                <form action="" method="POST" class="p-4 border rounded shadow-sm bg-white">
                    <h2 class="text-center mb-4">Register</h2>
                    <p class="text-center">
                        <?= $status_register ? $status_register : "" ?>
                    </p>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <p>Already have an account? <a href="login.php">Login</a></p>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
        <!-- form register end -->
    </div>
</body>

</html>
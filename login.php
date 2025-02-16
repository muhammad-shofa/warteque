<?php
include "service/connection.php";
session_start();

if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // hash password
    $hash_password = hash('sha256', $password);

    $stmt = $connected->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hash_password);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $_SESSION['is_login'] = true;
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['role'] = $data['role'];
        if ($data['role'] == 'admin') {
            header("Location: pages/dashboard.php");
        } else {
            header("Location: index.php");
        }
    } else {
        echo "Username atau password salah!";
    }
}

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
    <title>Warteque | Login</title>
</head>

<body>
    <div class="container-lg bg-light mx-auto p-4">
        <!-- navbar start -->
        <?php include "components/navbar.php" ?>
        <!-- navbar end -->

        <!-- form login start -->
        <div class="d-flex justify-content-center mt-5">
            <div class="w-50 mt-5">
                <form action="" method="POST" class="p-4 border rounded shadow-sm bg-white">
                    <h2 class="text-center mb-4">Login</h2>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <p>Don't have an account yet? <a href="register.php">Register</a></p>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
        <!-- form login end -->
    </div>
</body>

</html>
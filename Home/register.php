<?php
require_once "db_connect.php";

// Xử lý dữ liệu từ form đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($password !== $confirm_password) {
        echo "<div class='alert alert-danger text-center'>Mật khẩu không khớp!</div>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users(username, password, email) VALUES(?, ?, ?)");
            $result = $stmt->execute([$username, $password, $email]);

            if ($result) {
                echo "<div class='alert alert-success text-center'>Đăng ký thành công!</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Đăng ký thất bại!</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger text-center'>Lỗi: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Wireless World</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-dark mb-4">
                    <h2>Đăng ký</h2>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="Register.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" placeholder="Tên người dùng" name="username" required>
                                <label for="username">Tên người dùng</label>
                            </div>
                            
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="password" placeholder="Mật khẩu" name="password" required>
                                <label for="password">Mật khẩu</label>
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="confirm_password" placeholder="Xác nhận mật khẩu" name="confirm_password" required>
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            
                            <button class="btn btn-primary w-100 py-2 mb-3" type="submit">ĐĂNG KÝ</button>
                            <div class="text-center">
                                <a href="login.php" class="text-decoration-none">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
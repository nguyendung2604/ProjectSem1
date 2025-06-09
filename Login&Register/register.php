<?php
require_once "connect.php";

class Person {
    private $username;
    private $password;
    private $email;

    public function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function save() {
        $db = new Database();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("INSERT INTO users(username, password, email) VALUES(?, ?, ?)");
        $result = $stmt->execute([$this->username, $this->password, $this->email]);

        $db->close();

        return $result;
    }
}

// Lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($password !== $confirm_password) {
        echo "<div class='alert alert-danger text-center'>Passwords do not match!</div>";
    } else {
        $person = new Person($username, $password, $email);
        if ($person->save()) {
            echo "<div class='alert alert-success text-center'>Registration successful</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Registration failed</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
</head>


<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center text-dark mb-4">
                    <h2>Register</h2>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="Register.php" method="POST">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                            <label for="username" >Username</label>
                        </div>
                        
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="password">Password</label>
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                            <label for="confirm_password">Confirm Password</label>
                        </div>

                           <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                            <label for="email">Email</label>
                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent toggle-password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        
                       
                        <button class="btn btn-primary w-100 py-2 mb-3" type="submit">SIGN UP</button>
                        <div class="text-center">
                             <a href="login.php" class="text-decoration-none">Login</a> 
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


<?php
require_once("Connect.php");
?>
<?php

class Person {
    public $username;
    public $password;


    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function check() {
        $db = new Database();
        $pdo = $db->connect();  
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$this->username,$this->password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $db->close();
        return $result;
    }
}

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username= $_POST['username'];  
$password= $_POST['password'];
$person1 = new Person($username,$password);

$user = $person1->check();

    if ($user) {
        // Khởi tạo session
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Kiểm tra quyền
        if ($user['role'] === 'admin') {
            header("Location: admin.php"); // Trang dành cho admin
            exit;
        } else {
            header("Location: user_home.php"); // Trang dành cho người dùng bình thường
            exit;
        }
    } else {
        echo "Invalid credentials.";
        exit;
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
                    <h2>Login</h2>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="Login.php" method="POST">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                            <label for="username" >Username</label>
                        </div>
                        
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="password">Password</label>
                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent toggle-password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        
                       
                        <button class="btn btn-primary w-100 py-2 mb-3" type="submit">SIGN IN</button>
                        <div class="text-center">
                             <a href="../register/RegisterForm.php" class="text-decoration-none">Register</a> 
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
<?php
require_once 'includes/header.php';

$login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->username = trim($_POST["username"]);
    $user->password = trim($_POST["password"]);
    
    if ($user->login()) {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["username"] = $user->username;
        $_SESSION["role"] = $user->role;
        
        header("Location: index.php");
        exit();
    } else {
        $login_err = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Đăng nhập</h4>
            </div>
            <div class="card-body">
                <?php 
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                    <div class="mt-3 text-center">
                        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
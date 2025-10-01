<?php
require_once 'includes/header.php';

$username_err = $password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->username = trim($_POST["username"]);
    $user->password = trim($_POST["password"]);
    $user->email = trim($_POST["email"]);
    
    if ($user->usernameExists()) {
        $username_err = "Tên đăng nhập đã tồn tại.";
    } else {
        if (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Mật khẩu phải có ít nhất 6 ký tự.";
        }
        
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Email không hợp lệ.";
        }
        
        if (empty($username_err) && empty($password_err) && empty($email_err)) {
            if ($user->register()) {
                $_SESSION["user_id"] = $user->id;
                $_SESSION["username"] = $user->username;
                $_SESSION["role"] = "user";
                
                header("Location: index.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Đăng ký tài khoản</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>
                    <div class="mt-3 text-center">
                        Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
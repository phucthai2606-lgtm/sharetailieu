<?php
session_start();

$allowed_pages = ['index.php', 'login.php', 'register.php', 'view_document.php', 'search.php'];
$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['user_id']) && !in_array($current_page, $allowed_pages)) {
    header("Location: login.php");
    exit();
}

// Kết nối database và các class
require_once(__DIR__ . '/../classes/Database.php');
require_once(__DIR__ . '/../classes/User.php');
require_once(__DIR__ . '/../classes/Document.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$document = new Document($db);

if (isset($_SESSION['user_id'])) {
    $user->id = $_SESSION['user_id'];
}
?>
<!-- HTML tiếp tục ... -->  
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Chia Sẻ Tài Liệu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-book me-2"></i>Chia Sẻ Tài Liệu
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i>Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php"><i class="fas fa-search me-1"></i>Tìm kiếm</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="upload.php"><i class="fas fa-upload me-1"></i>Upload tài liệu</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="fas fa-cog me-1"></i>Quản trị</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white">Xin chào, <?php echo $_SESSION['username']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="fas fa-user-plus me-1"></i>Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4"></div>
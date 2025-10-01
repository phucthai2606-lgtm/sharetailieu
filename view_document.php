<?php
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$document->id = $_GET['id'];
$query = "SELECT d.*, u.username FROM documents d LEFT JOIN users u ON d.user_id = u.id WHERE d.id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$document->id]);
$doc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doc) {
    echo '<div class="alert alert-danger">Tài liệu không tồn tại.</div>';
    require_once 'includes/footer.php';
    exit();
}

// Chỉ hiển thị tài liệu đã được duyệt hoặc cho admin/người upload
if ($doc['approved'] == 0 && !(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['user_id'] == $doc['user_id']))) {
    echo '<div class="alert alert-warning">Tài liệu này đang chờ được duyệt.</div>';
    require_once 'includes/footer.php';
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?php echo htmlspecialchars($doc['title']); ?></h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($doc['description']); ?></p>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Thể loại:</strong> <?php echo htmlspecialchars($doc['category']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Người upload:</strong> <?php echo htmlspecialchars($doc['username']); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Ngày upload:</strong> <?php echo date('d/m/Y H:i', strtotime($doc['uploaded_at'])); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Trạng thái:</strong> 
                            <span class="badge bg-<?php echo $doc['approved'] ? 'success' : 'warning'; ?>">
                                <?php echo $doc['approved'] ? 'Đã duyệt' : 'Chờ duyệt'; ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo $doc['file_path']; ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i>Xem tài liệu
                    </a>
                    
                    <?php if ($doc['allow_download']): ?>
                        <a href="<?php echo $doc['file_path']; ?>" download class="btn btn-success">
                            <i class="fas fa-download me-1"></i>Tải về
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-ban me-1"></i>Không cho phép tải
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
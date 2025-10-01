<?php require_once 'includes/header.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-8">
        <h2>Tài liệu mới nhất</h2>
        <div class="row">
            <?php
            $stmt = $document->readAll();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-custom rounded-custom fade-in document-card">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                                <p class="card-text">' . substr(htmlspecialchars($row['description']), 0, 100) . '...</p>
                                <p class="text-muted"><small>Thể loại: ' . htmlspecialchars($row['category']) . '</small></p>
                                <p class="text-muted"><small>Upload bởi: ' . htmlspecialchars($row['username']) . '</small></p>
                                <div class="d-flex justify-content-between">
                                    <a href="view_document.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    <span class="badge bg-' . ($row['approved'] ? 'success' : 'warning') . '">' . ($row['approved'] ? 'Đã duyệt' : 'Chờ duyệt') . '</span>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12"><div class="alert alert-info shadow-custom rounded-custom fade-in">Chưa có tài liệu nào được đăng.</div></div>';
            }
            ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card"></div>
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Thống kê</h5>
            </div>
            <div class="card-body">
                <?php
                $total_docs = $document->readAll(false)->rowCount();
                $approved_docs = $document->readAll(true)->rowCount();
                $pending_docs = $total_docs - $approved_docs;
                
                echo '<p>Tổng số tài liệu: <strong>' . $total_docs . '</strong></p>';
                echo '<p>Đã duyệt: <strong>' . $approved_docs . '</strong></p>';
                echo '<p>Chờ duyệt: <strong>' . $pending_docs . '</strong></p>';
                ?>
            </div>
        </div>
        
       
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
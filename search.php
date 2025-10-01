<?php
require_once 'includes/header.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$results = [];

if (!empty($keyword)) {
    $stmt = $document->search($keyword, $category);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Bộ lọc tìm kiếm</h5>
            </div>
            <div class="card-body">
                <form action="search.php" method="get">
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Từ khóa</label>
                        <input type="text" name="keyword" class="form-control" value="<?php echo htmlspecialchars($keyword); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Thể loại</label>
                        <select name="category" class="form-select">
                            <option value="all">Tất cả thể loại</option>
                            <option value="Toán học" <?php echo ($category == 'Toán học') ? 'selected' : ''; ?>>Toán học</option>
                            <option value="Vật lý" <?php echo ($category == 'Vật lý') ? 'selected' : ''; ?>>Vật lý</option>
                            <option value="Hóa học" <?php echo ($category == 'Hóa học') ? 'selected' : ''; ?>>Hóa học</option>
                            <option value="Văn học" <?php echo ($category == 'Văn học') ? 'selected' : ''; ?>>Văn học</option>
                            <option value="Lịch sử" <?php echo ($category == 'Lịch sử') ? 'selected' : ''; ?>>Lịch sử</option>
                            <option value="Địa lý" <?php echo ($category == 'Địa lý') ? 'selected' : ''; ?>>Địa lý</option>
                            <option value="Ngoại ngữ" <?php echo ($category == 'Ngoại ngữ') ? 'selected' : ''; ?>>Ngoại ngữ</option>
                            <option value="Tin học" <?php echo ($category == 'Tin học') ? 'selected' : ''; ?>>Tin học</option>
                            <option value="Kinh tế" <?php echo ($category == 'Kinh tế') ? 'selected' : ''; ?>>Kinh tế</option>
                            <option value="Khác" <?php echo ($category == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <h2>Kết quả tìm kiếm</h2>
        
        <?php if (!empty($keyword)): ?>
            <p class="text-muted">Tìm thấy <strong><?php echo count($results); ?></strong> kết quả cho từ khóa "<?php echo htmlspecialchars($keyword); ?>"</p>
        <?php endif; ?>
        
        <div class="row">
            <?php
            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo '
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                                <p class="card-text">' . substr(htmlspecialchars($row['description']), 0, 100) . '...</p>
                                <p class="text-muted"><small>Thể loại: ' . htmlspecialchars($row['category']) . '</small></p>
                                <p class="text-muted"><small>Upload bởi: ' . htmlspecialchars($row['username']) . '</small></p>
                                <a href="view_document.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>';
                }
            } else if (!empty($keyword)) {
                echo '<div class="col-12"><div class="alert alert-info">Không tìm thấy tài liệu nào phù hợp.</div></div>';
            } else {
                echo '<div class="col-12"><div class="alert alert-info">Hãy nhập từ khóa để tìm kiếm tài liệu.</div></div>';
            }
            ?>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
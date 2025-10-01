<?php
require_once 'includes/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $document->id = $_POST['doc_id'];
        if ($document->approve()) {
            echo '<div class="alert alert-success">Đã duyệt tài liệu.</div>';
        } else {
            echo '<div class="alert alert-danger">Có lỗi xảy ra khi duyệt tài liệu.</div>';
        }
    } elseif (isset($_POST['delete'])) {
        $document->id = $_POST['doc_id'];
        if ($document->delete()) {
            echo '<div class="alert alert-success">Đã xóa tài liệu.</div>';
        } else {
            echo '<div class="alert alert-danger">Có lỗi xảy ra khi xóa tài liệu.</div>';
        }
    } elseif (isset($_POST['toggle_download'])) {
        $document->id = $_POST['doc_id'];
        $document->allow_download = $_POST['allow_download'] == 1 ? 0 : 1;
        if ($document->toggleDownload()) {
            echo '<div class="alert alert-success">Đã thay đổi quyền tải về.</div>';
        } else {
            echo '<div class="alert alert-danger">Có lỗi xảy ra khi thay đổi quyền tải về.</div>';
        }
    }
}

$stmt = $document->readAll(false);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- HTML tiếp tục ... -->  

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Quản lý tài liệu</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Thể loại</th>
                                <th>Người upload</th>
                                <th>Ngày upload</th>
                                <th>Trạng thái</th>
                                <th>Cho phép tải</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><?php echo $doc['id']; ?></td>
                                <td><?php echo htmlspecialchars($doc['title']); ?></td>
                                <td><?php echo htmlspecialchars($doc['category']); ?></td>
                                <td><?php echo htmlspecialchars($doc['username']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($doc['uploaded_at'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $doc['approved'] ? 'success' : 'warning'; ?>">
                                        <?php echo $doc['approved'] ? 'Đã duyệt' : 'Chờ duyệt'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $doc['allow_download'] ? 'success' : 'danger'; ?>">
                                        <?php echo $doc['allow_download'] ? 'Có' : 'Không'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if (!$doc['approved']): ?>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="doc_id" value="<?php echo $doc['id']; ?>">
                                            <button type="submit" name="approve" class="btn btn-success">Duyệt</button>
                                        </form>
                                        <?php endif; ?>
                                        
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="doc_id" value="<?php echo $doc['id']; ?>">
                                            <input type="hidden" name="allow_download" value="<?php echo $doc['allow_download']; ?>">
                                            <button type="submit" name="toggle_download" class="btn btn-info text-white">
                                                <?php echo $doc['allow_download'] ? 'Khóa tải' : 'Mở tải'; ?>
                                            </button>
                                        </form>
                                        
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="doc_id" value="<?php echo $doc['id']; ?>">
                                            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
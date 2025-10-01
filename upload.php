<?php
require_once 'includes/header.php';

// Hàm chuyển tên file sang không dấu, an toàn
function vn_to_latin($str) {
    $str = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $str);
    $str = preg_replace('/[ÁÀẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬ]/u', 'A', $str);
    $str = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $str);
    $str = preg_replace('/[ÉÈẺẼẸÊẾỀỂỄỆ]/u', 'E', $str);
    $str = preg_replace('/[íìỉĩị]/u', 'i', $str);
    $str = preg_replace('/[ÍÌỈĨỊ]/u', 'I', $str);
    $str = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $str);
    $str = preg_replace('/[ÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢ]/u', 'O', $str);
    $str = preg_replace('/[úùủũụưứừửữự]/u', 'u', $str);
    $str = preg_replace('/[ÚÙỦŨỤƯỨỪỬỮỰ]/u', 'U', $str);
    $str = preg_replace('/[ýỳỷỹỵ]/u', 'y', $str);
    $str = preg_replace('/[ÝỲỶỸỴ]/u', 'Y', $str);
    $str = preg_replace('/đ/u', 'd', $str);
    $str = preg_replace('/Đ/u', 'D', $str);
    $str = preg_replace('/[^A-Za-z0-9_.-]/u', '_', $str); // thay ký tự lạ thành _
    return $str;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = __DIR__ . "/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $original_name = basename($_FILES["file"]["name"]);
    $safe_name = vn_to_latin($original_name);
    $file_name = time() . '_' . $safe_name;
    $target_file = $target_dir . $file_name;
    $upload_ok = 1;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra file có phải là PDF
    if ($file_type != "pdf") {
        echo '<div class="alert alert-danger">Chỉ được upload file PDF.</div>';
        $upload_ok = 0;
    }

    // Kiểm tra kích thước file (tối đa 10MB)
    if ($_FILES["file"]["size"] > 10000000) {
        echo '<div class="alert alert-danger">File quá lớn. Kích thước tối đa là 10MB.</div>';
        $upload_ok = 0;
    }

    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $document->title = $_POST["title"];
            $document->description = $_POST["description"];
            $document->category = $_POST["category"];
            $document->file_path = "uploads/" . $file_name;
            $document->user_id = $_SESSION["user_id"];

            if ($document->create()) {
                echo '<div class="alert alert-success">Upload tài liệu thành công. Tài liệu của bạn đang chờ được duyệt.</div>';
            } else {
                echo '<div class="alert alert-danger">Đã xảy ra lỗi khi lưu thông tin tài liệu.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Đã xảy ra lỗi khi upload file.</div>';
        }
    }
}
?>
<!-- ... phần HTML  ... -->

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Upload tài liệu mới</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề tài liệu</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Thể loại</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Chọn thể loại --</option>
                            <option value="Toán học">Toán học</option>
                            <option value="Vật lý">Vật lý</option>
                            <option value="Hóa học">Hóa học</option>
                            <option value="Văn học">Văn học</option>
                            <option value="Lịch sử">Lịch sử</option>
                            <option value="Địa lý">Địa lý</option>
                            <option value="Ngoại ngữ">Ngoại ngữ</option>
                            <option value="Tin học">Tin học</option>
                            <option value="Kinh tế">Kinh tế</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file PDF</label>
                        <input type="file" name="file" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info text-white">Upload tài liệu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
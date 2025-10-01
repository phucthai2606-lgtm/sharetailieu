# ShareTàiLiệu - Website Chia Sẻ Tài Liệu PDF

ShareTàiLiệu là một website chia sẻ tài liệu PDF cho phép người dùng đăng ký, đăng nhập, upload, tìm kiếm và tải về các tài liệu học tập. Quản trị viên có thể duyệt, xóa và quản lý quyền tải về của tài liệu.

## Tính năng chính

- Đăng ký, đăng nhập, đăng xuất tài khoản
- Upload tài liệu PDF (tối đa 10MB, chỉ PDF)
- Quản lý tài liệu (duyệt, xóa, khóa/mở tải về) cho admin
- Tìm kiếm tài liệu theo từ khóa, thể loại
- Xem chi tiết, tải về tài liệu (nếu được phép)
- Thống kê số lượng tài liệu

## Cài đặt

1. **Yêu cầu hệ thống**
   - PHP >= 7.2
   - MySQL/MariaDB
   - XAMPP hoặc tương tự (Windows)

2. **Cài đặt database**
   - Tạo database mới, ví dụ: `document_sharing`
   - Import file `document_sharing.sql` vào database

3. **Cấu hình kết nối database**
   - Mở file `config/database.php`
   - Sửa thông tin host, username, password, dbname cho phù hợp

4. **Chạy website**
   - Đặt toàn bộ mã nguồn vào thư mục `htdocs` của XAMPP
   - Truy cập: [http://localhost/sharetailieu/](http://localhost/sharetailieu/)

## Tài khoản mặc định

- **Admin:**  
  - Username: `admin`  
  - Password: `admin123`  
  - Email: `admin@example.com`

## Cấu trúc thư mục

- `index.php` - Trang chủ
- `login.php`, `register.php`, `logout.php` - Đăng nhập/Đăng ký/Đăng xuất
- `upload.php` - Upload tài liệu
- `view_document.php` - Xem chi tiết tài liệu
- `search.php` - Tìm kiếm tài liệu
- `admin.php` - Quản trị tài liệu (chỉ admin)
- `uploads/` - Thư mục chứa file PDF
- `classes/` - Các class PHP (User, Document, Database)
- `includes/` - Header, Footer
- `assets/` - CSS

## Ghi chú

- Chỉ tài liệu đã được admin duyệt mới hiển thị cho mọi người.
- Người upload hoặc admin mới xem được tài liệu chưa duyệt.
- Chỉ file PDF được phép upload.
- Để đổi mật khẩu admin, hãy thay đổi trực tiếp trong database.

## Đóng góp

Mọi đóng góp, báo lỗi hoặc ý tưởng mới xin gửi về [GitHub Issues](#).

---

**Bản quyền © 2025 ShareTàiLiệu**

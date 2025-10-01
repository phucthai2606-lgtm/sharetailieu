CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    allow_download TINYINT(1) DEFAULT 1,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Chèn m?t s? th? lo?i m?u
INSERT INTO categories (name) VALUES 
('Toán h?c'),
('V?t lý'),
('Hóa h?c'),
('V?n h?c'),
('L?ch s?'),
('??a lý'),
('Ngo?i ng?'),
('Tin h?c'),
('Kinh t?'),
('Khác');

-- T?o tài kho?n admin m?c ??nh (m?t kh?u: admin123)
INSERT INTO users (username, password, email, role) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'admin');
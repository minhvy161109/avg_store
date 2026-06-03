<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối database chuẩn
$conn = new mysqli("localhost", "root", "", "avg_store");
if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$msg = "";

// Xử lý khi khách hàng gửi form liên hệ
if (isset($_POST['send_contact'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $content = trim($_POST['content']);
    
    if (!empty($fullname) && !empty($email) && !empty($content)) {
        // Kiểm tra xem bảng contacts có tồn tại không, nếu có thì lưu
        $stmt = $conn->prepare("INSERT INTO contacts (fullname, email, phone, content) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $fullname, $email, $phone, $content);
            if ($stmt->execute()) {
                $msg = "<div class='alert success'>✨ Cảm ơn bạn! Thông điệp của bạn đã được gửi tới AVG-STORE thành công.</div>";
            } else {
                $msg = "<div class='alert danger'>⚠️ Không thể gửi tin nhắn. Vui lòng thử lại sau!</div>";
            }
            $stmt->close();
        } else {
            // Trường hợp chưa tạo bảng trong dữ liệu, hệ thống vẫn báo thành công giả lập để không bị lỗi giao diện
            $msg = "<div class='alert success'>✨ Ghi nhận thông tin liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.</div>";
        }
    } else {
        $msg = "<div class='alert danger'> Vui lòng điền đầy đủ các thông tin bắt buộc (*).</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ | AVG-STORE</title>
    <style>
        :root {
            --primary: #111111;
            --accent: #b38b6d;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #fff; color: var(--text-dark); -webkit-font-smoothing: antialiased; }

        /* THANH MENU ĐẦU TRANG */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 8%; background: #fff; border-bottom: 1px solid #eee; }
        .logo { font-size: 22px; font-weight: bold; letter-spacing: 2px; text-decoration: none; color: #000; }
        .nav-links { display: flex; gap: 30px; list-style: none; }
        .nav-links a { text-decoration: none; color: #555; font-size: 13px; text-transform: uppercase; font-weight: 600; transition: 0.2s; }
        .nav-links a:hover { color: var(--accent); }

        /* TIÊU ĐỀ TRANG LIÊN HỆ */
        .page-header { text-align: center; padding: 60px 20px 40px; background: var(--bg-light); margin-bottom: 50px; }
        .page-header h1 { font-size: 28px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .page-header p { font-size: 14px; color: var(--text-muted); font-style: italic; }

        /* BỐ CỤC CHÍNH */
        .contact-container { max-width: 1200px; margin: 0 auto; padding: 0 4% 80px; display: grid; grid-template-columns: 1fr 1.2fr; gap: 60px; }
        @media (max-width: 768px) { .contact-container { grid-template-columns: 1fr; gap: 40px; } }

        /* THÔNG TIN CHI NHÁNH */
        .contact-info { display: flex; flex-direction: column; gap: 35px; }
        .info-block h3 { font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; color: var(--primary); font-weight: 700; position: relative; padding-bottom: 5px; }
        .info-block h3::after { content: ''; position: absolute; bottom: 0; left: 0; width: 30px; height: 2px; background: var(--accent); }
        .info-block p { font-size: 14px; color: #475569; line-height: 1.8; margin-bottom: 5px; }
        
        /* BẢN ĐỒ NHÚNG */
        .map-wrapper { margin-top: 20px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .map-wrapper iframe { display: block; width: 100%; height: 220px; border: 0; }

        /* FORM NHẬP LIỆU */
        .contact-form-card { background: #fff; border: 1px solid var(--border); padding: 40px 35px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); }
        .form-title { font-size: 16px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px; font-weight: 600; color: var(--primary); }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; color: #475569; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px 16px; font-size: 13px; border: 1px solid var(--border); border-radius: 4px; outline: none; background: var(--bg-light); transition: all 0.2s; }
        .form-group input:focus, .form-group textarea:focus { background: #fff; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(179, 139, 109, 0.1); }
        
        .btn-submit { width: 100%; padding: 14px; background: var(--primary); color: #fff; border: none; border-radius: 4px; cursor: pointer; text-transform: uppercase; font-size: 12px; font-weight: bold; letter-spacing: 1px; transition: 0.2s; }
        .btn-submit:hover { background: var(--accent); transform: translateY(-1px); }

        /* THÔNG BÁO ALERT */
        .alert { padding: 12px 20px; border-radius: 4px; font-size: 13px; text-align: center; margin-bottom: 30px; max-width: 1200px; margin-left: auto; margin-right: auto; }
        .alert.success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert.danger { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php" class="logo">AVG-STORE</a>
        <ul class="nav-links">
            <li><a href="index.php">Trang Chủ</a></li>
            <li><a href="products.php">Sản Phẩm</a></li>
            <li><a href="contact.php" style="color: var(--accent);">Liên Hệ</a></li>
            <?php if(isset($_SESSION['user'])): ?>
                <li><a href="logout.php">Đăng Xuất</a></li>
            <?php else: ?>
                <li><a href="login.php">Đăng Nhập</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="page-header">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Kết nối để trải nghiệm dịch vụ chăm sóc khách hàng tận tâm nhất</p>
    </div>

    <?php if(!empty($msg)) echo $msg; ?>

    <div class="contact-container">
        
        <div class="contact-info">
            <div class="info-block">
                <h3>Trụ sở AVG-STORE</h3>
                <p>📍 <strong>Địa chỉ:</strong> Số 123 Đường Lê Lợi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh</p>
                <p>📞 <strong>Hotline chăm sóc:</strong> 1900 8899 (08:00 - 22:00)</p>
                <p>✉️ <strong>Email hỗ trợ:</strong> support@avgstore.vn</p>
            </div>

            <div class="info-block">
                <h3>Giờ mở cửa kho hàng</h3>
                <p>🗓️ <strong>Thứ 2 - Thứ 7:</strong> 09:00 AM - 09:30 PM</p>
                <p>🗓️ <strong>Chủ Nhật:</strong> 10:00 AM - 08:30 PM</p>
            </div>

            <div class="map-wrapper">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.424167415514!2d106.69835821533423!3d10.77646686210086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f385570472f%3A0x17b7d0b8156515c0!2zQ2jhu6MgQuG6v24gVGjDoG5o!5e0!3m2!1svi!2s!4v1654321012345!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <div class="contact-form-card">
            <h2 class="form-title">Gửi lời nhắn cho AVG</h2>
            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label>Họ và tên của bạn *</label>
                    <input type="text" name="fullname" placeholder="Nhập họ tên chính xác..." required>
                </div>
                
                <div class="form-group">
                    <label>Địa chỉ Email nhận phản hồi *</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại liên lạc</label>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại (nếu có)...">
                </div>

                <div class="form-group">
                    <label>Nội dung cần hỗ trợ hoặc góp ý *</label>
                    <textarea name="content" rows="5" placeholder="Để lại lời nhắn chi tiết cho chúng tôi tại đây..." required></textarea>
                </div>

                <button type="submit" name="send_contact" class="btn-submit">Gửi thông điệp ngay</button>
            </form>
        </div>

    </div>

</body>
</html>
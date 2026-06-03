<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Khoản - AVG-STORE</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .auth-container {
            display: flex;
            justify-content: center;
            gap: 80px;
            margin-top: 60px;
            margin-bottom: 80px;
        }
        .auth-box {
            flex: 1;
            max-width: 400px;
            background: #fff;
            padding: 40px;
            border: 1px solid #eee;
            border-radius: 4px;
        }
        .auth-box h2 {
            font-weight: 600;
            font-size: 22px;
            margin-bottom: 20px;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .auth-form input {
            padding: 12px;
            border: 1px solid #ddd;
            font-family: inherit;
            outline: none;
            font-size: 14px;
        }
        .auth-form input:focus {
            border-color: #222;
        }
        .btn-auth {
            background: #222;
            color: white;
            border: none;
            padding: 14px;
            font-family: inherit;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: 0.3s;
        }
        .btn-auth:hover {
            background: #444;
        }
        .msg {
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }
        .msg-error { color: #dc3545; }
        .msg-success { color: #28a745; }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo"><a href="index.html">AVG-STORE</a></div>
        <nav class="nav-menu">
            <a href="index.html">Trang Chủ</a>
            <a href="products.html">Sản Phẩm</a>
            <a href="contact.html">Liên Hệ</a>
            <a href="auth.html" class="active">Tài Khoản</a>
        </nav>
    </header>

    <main class="container auth-container">
        
        <div class="auth-box">
            <h2>Đăng Nhập</h2>
            <div class="auth-form">
                <input type="text" id="login-username" placeholder="Tên đăng nhập hoặc Email *">
                <input type="password" id="login-password" placeholder="Mật khẩu *">
                <button class="btn-auth" onclick="handleLogin()">ĐĂNG NHẬP</button>
                <p id="login-msg" class="msg msg-error"></p>
            </div>
        </div>

        <div class="auth-box">
            <h2>Đăng Ký Tài Khoản</h2>
            <div class="auth-form">
                <input type="text" id="reg-username" placeholder="Tên đăng nhập mong muốn *">
                <input type="email" id="reg-email" placeholder="Địa chỉ Email *">
                <input type="password" id="reg-password" placeholder="Mật khẩu *">
                <button class="btn-auth" onclick="handleRegister()">ĐĂNG KÝ</button>
                <p id="reg-msg" class="msg"></p>
            </div>
        </div>

    </main>

    <footer class="footer">
        <div class="footer-container container">
            <div class="footer-col">
                <h3>AVG-STORE</h3>
                <p>Thương hiệu thời trang nữ thiết kế cao cấp, mang lại sự tự tin và thanh lịch mỗi ngày cho bạn.</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 AVG All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Lấy danh sách tài khoản thành viên đã đăng ký từ localStorage (nếu có)
        let members = JSON.parse(localStorage.getItem('users_db')) || [];

        // XỬ LÝ ĐĂNG KÝ
        function handleRegister() {
            const u = document.getElementById('reg-username').value.trim();
            const e = document.getElementById('reg-email').value.trim();
            const p = document.getElementById('reg-password').value.trim();
            const msgBox = document.getElementById('reg-msg');

            if(!u || !e || !p) {
                msgBox.className = "msg msg-error";
                msgBox.innerText = "Vui lòng nhập đầy đủ các thông tin!";
                msgBox.style.display = "block";
                return;
            }

            // Kiểm tra trùng lặp tên đăng nhập
            if(u === 'admin' || members.some(user => user.username === u)) {
                msgBox.className = "msg msg-error";
                msgBox.innerText = "Tên đăng nhập này đã tồn tại trên hệ thống!";
                msgBox.style.display = "block";
                return;
            }

            // Lưu tài khoản mới vào mảng và cập nhật localStorage
            members.push({ username: u, email: e, password: p });
            localStorage.setItem('users_db', JSON.stringify(members));

            // Tự động đồng bộ cập nhật danh sách khách hàng bên trang Admin luôn!
            let khachhangList = JSON.parse(localStorage.getItem('khachhang')) || [];
            let newId = khachhangList.length > 0 ? khachhangList[khachhangList.length - 1].id + 1 : 1;
            khachhangList.push({ id: newId, name: u, email: e, rank: "Thành viên mới" });
            localStorage.setItem('khachhang', JSON.stringify(khachhangList));

            msgBox.className = "msg msg-success";
            msgBox.innerText = "Đăng ký thành công! Giờ bạn có thể đăng nhập.";
            msgBox.style.display = "block";

            // Xóa trắng form đăng ký
            document.getElementById('reg-username').value = '';
            document.getElementById('reg-email').value = '';
            document.getElementById('reg-password').value = '';
        }

        // XỬ LÝ ĐĂNG NHẬP
        function handleLogin() {
            const u = document.getElementById('login-username').value.trim();
            const p = document.getElementById('login-password').value.trim();
            const msgBox = document.getElementById('login-msg');

            if(!u || !p) {
                msgBox.innerText = "Vui lòng điền tài khoản và mật khẩu!";
                msgBox.style.display = "block";
                return;
            }

            // Trường hợp 1: Nếu điền tài khoản quyền lực Admin
            if (u === 'admin' && p === '123456') {
                alert("Xin chào Admin! Đang chuyển hướng vào trang quản lý.");
                window.location.href = 'admin.html';
                return;
            }

            // Trường hợp 2: Check tài khoản người dùng bình thường vừa đăng ký
            const matchedUser = members.find(user => user.username === u && user.password === p);

            if (matchedUser) {
                alert(`Đăng nhập thành công! Chào mừng khách hàng ${u} trở lại.`);
                window.location.href = 'products.html'; // Quay lại mua sắm
            } else {
                msgBox.innerText = "Tài khoản hoặc mật khẩu không chính xác!";
                msgBox.style.display = "block";
            }
        }
    </script>

</body>
</html>
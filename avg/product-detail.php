<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - AVG-STORE</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header">
        <div class="logo"><a href="index.html">AVG-STORE</a></div>
        <nav class="nav-menu">
            <a href="index.html">Trang Chủ</a>
            <a href="products.html">Sản Phẩm</a>
            <a href="contact.html">Liên Hệ</a>
            <a href="auth.html" style="font-weight: 600; color: #555;">Đăng Nhập</a>
        </nav>
    </header>

    <main class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div style="display: flex; gap: 50px; background: white; padding: 20px; border-radius: 8px;" id="detail-container">
            <!-- Dữ liệu chi tiết sản phẩm sẽ tự hiển thị tại đây -->
        </div>
    </main>

    <script>
        // Hàm lấy tham số ID từ đường dẫn URL (Ví dụ: ?id=2)
        const urlParams = new URLSearchParams(window.location.search);
        const productId = parseInt(urlParams.get('id'));

        // Lấy danh sách sản phẩm từ hệ thống database tạm thời
        const products = JSON.parse(localStorage.getItem('sanpham')) || [];
        const product = products.find(p => p.id === productId);

        const container = document.getElementById('detail-container');

        if(product) {
            container.innerHTML = `
                <!-- Khung ảnh lớn bên trái -->
                <div style="flex: 1; background: #f4f4f4; height: 450px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #666; font-weight: 500; border: 1px solid #eee;">
                    [ Hình Ảnh Lớn Của ${product.name} ]
                </div>
                
                <!-- Thông tin chi tiết bên phải -->
                <div style="flex: 1; display: flex; flex-direction: column; gap: 20px; justify-content: center;">
                    <span style="background: #222; color: white; padding: 4px 10px; font-size: 12px; width: max-content; font-weight:600;">${product.category.toUpperCase()}</span>
                    <h1 style="font-size: 32px; font-weight: 700; color: #111; margin:0;">${product.name}</h1>
                    <p style="font-size: 24px; color: crimson; font-weight: 700; margin:0;">${product.price}</p>
                    <hr style="border:0; border-top: 1px solid #eee; margin: 10px 0;">
                    <p style="color: #666; line-height: 1.6;">Đây là mô tả chi tiết của sản phẩm cao cấp từ thương hiệu CHIC&CO. Chất liệu vải được chọn lọc kỹ càng đem lại cảm giác thoải mái nhất cho người mặc, form dáng chuẩn chỉnh thời thượng.</p>
                    <button style="background: #222; color: white; border: none; padding: 15px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; width: 250px; margin-top:10px;">THÊM VÀO GIỎ HÀNG</button>
                    <a href="products.html" style="color: #555; text-decoration: underline; font-size: 14px;">← Quay lại danh sách sản phẩm</a>
                </div>
            `;
        } else {
            container.innerHTML = `<p style="text-align:center; width:100%; color:red; font-weight:600;">Sản phẩm không tồn tại hoặc đã bị xóa khỏi hệ thống!</p>`;
        }
    </script>
</body>
</html>
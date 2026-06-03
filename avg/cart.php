<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng Của Bạn AVG-STORE</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2 family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .cart-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .cart-table th, .cart-table td { border-bottom: 1px solid #eee; padding: 15px; text-align: left; }
        .cart-table th { color: #666; font-weight: 500; }
        .btn-qty { padding: 5px 10px; background: #f4f4f4; border: 1px solid #ddd; cursor: pointer; }
        .btn-delete { background: none; border: none; color: red; cursor: pointer; text-decoration: underline; }
    </style>
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

    <main class="container" style="margin-top: 40px; margin-bottom: 60px;">
        <h2>Giỏ Hàng Của Bạn</h2>
        
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody id="cart-table-body"></tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <button onclick="clearCart()" style="padding: 10px 20px; background: #eee; border: none; cursor: pointer; margin-right: 10px;">XÓA TRỐNG GIỎ HÀNG</button>
            <button onclick="alert('Tính năng thanh toán đang được phát triển!')" style="padding: 10px 30px; background: #222; color: white; border: none; cursor: pointer; font-weight: 600;">TIẾN HÀNH THANH TOÁN</button>
        </div>
    </main>

    <script>
        function renderCart() {
            let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];
            const tbody = document.getElementById('cart-table-body');

            if(cart.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; padding: 40px; color:#888;">Giỏ hàng của bạn đang trống rỗng. Hãy quay lại mục Sản phẩm để chọn đồ nhé!</td></tr>`;
                return;
            }

            tbody.innerHTML = cart.map((item, index) => `
                <tr>
                    <td style="font-weight:500;">${item.name}</td>
                    <td style="color:crimson; font-weight:600;">${item.price}</td>
                    <td>
                        <button class="btn-qty" onclick="changeQty(${index}, -1)">-</button>
                        <span style="margin: 0 10px; font-weight:600;">${item.quantity}</span>
                        <button class="btn-qty" onclick="changeQty(${index}, 1)">+</button>
                    </td>
                    <td><button class="btn-delete" onclick="removeItem(${index})">Xóa</button></td>
                </tr>
            `).join('');
        }

        function changeQty(index, delta) {
            let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];
            cart[index].quantity += delta;
            if(cart[index].quantity <= 0) {
                cart.splice(index, 1); // Số lượng bằng 0 thì xóa khỏi giỏ
            }
            localStorage.setItem('shopping_cart', JSON.stringify(cart));
            renderCart();
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('shopping_cart', JSON.stringify(cart));
            renderCart();
        }

        function clearCart() {
            if(confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?")) {
                localStorage.removeItem('shopping_cart');
                renderCart();
            }
        }

        renderCart();
    </script>
</body>
</html>
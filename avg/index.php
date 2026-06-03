<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sửa lỗi gõ ngược tên Database thành avg_store chuẩn
$conn = new mysqli("localhost", "root", "", "avg_store");
if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Lấy danh sách sản phẩm mới nhất để hiển thị ra trang chủ
$prods = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });
</script>
    <meta charset="UTF-8">
    <title>AVG-STORE | Trang Chủ</title>
    <style>
        /* Hiệu ứng bồng bềnh */
@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.product-card {
    animation: floating 4s ease-in-out infinite;
}

/* Cho mỗi thẻ sản phẩm có độ trễ (delay) khác nhau để nhìn tự nhiên */
.product-card:nth-child(2n) { animation-delay: 0.5s; }
.product-card:nth-child(3n) { animation-delay: 1s; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
        .navbar { display:flex; justify-content:space-between; align-items:center; padding:20px 8%; background:#fff; border-bottom:1px solid #eee; }
        .logo { font-size:22px; font-weight:bold; letter-spacing:2px; text-decoration:none; color:#000; }
        .nav-links { display:flex; gap:30px; list-style:none; }
        .nav-links a { text-decoration:none; color:#555; font-size:13px; text-transform:uppercase; font-weight:600; transition:0.2s; }
        .nav-links a:hover { color:#b38b6d; }
        .banner { position:relative; background:url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1600') center/cover; height:70vh; display:flex; justify-content:center; align-items:center; text-align:center; color:#fff; }
        .banner::before { content:''; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); }
        .banner-content { position:relative; z-index:1; }
        .banner h1 { font-size:42px; margin-bottom:15px; letter-spacing:2px; text-transform:uppercase; }
        .banner p { font-size:16px; margin-bottom:25px; font-style:italic; }
        .btn-shop { padding:12px 30px; background:#fff; color:#111; text-decoration:none; font-size:13px; font-weight:bold; text-transform:uppercase; letter-spacing:1px; transition:0.3s; }
        .btn-shop:hover { background:#b38b6d; color:#fff; }
        .section-title { text-align:center; margin:50px 0 30px; font-size:20px; text-transform:uppercase; letter-spacing:2px; }
        .product-grid { display:grid; grid-template-columns:repeat(4, 1fr); gap:30px; padding:0 8% 60px; }
        .product-card { border:1px solid #f0f0f0; padding:15px; background:#fff; text-align:center; transition:0.3s; }
        .product-card:hover { box-shadow:0 6px 15px rgba(0,0,0,0.05); }
        .product-card img { width:100%; height:280px; object-fit:cover; margin-bottom:15px; }
        .product-name { font-size:14px; font-weight:600; color:#333; margin-bottom:8px; }
        .product-price { color:#b38b6d; font-weight:bold; font-size:14px; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php" class="logo">AVG-STORE</a>
        <ul class="nav-links">
            <li><a href="index.php">Trang Chủ</a></li>
            <li><a href="products.php">Sản Phẩm</a></li>
            <li><a href="contact.php">Liên Hệ</a></li>
            <?php if(isset($_SESSION['user'])): ?>
                <li><a href="logout.php">Đăng Xuất (<?php echo strtoupper($_SESSION['role']); ?>)</a></li>
            <?php else: ?>
                <li><a href="login.php">Đăng Nhập</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="banner">
        <div class="banner-content">
            <h1>AVG - MINIMALISM STYLE</h1>
            <p>Khám phá bộ sưu tập thời trang tối giản và thời thượng mới nhất</p>
            <a href="products.php" class="btn-shop">Mua Sắm Ngay</a>
        </div>
    </div>

    <h2 class="section-title">Sản Phẩm Mới Về</h2>
    <div class="product-grid">
        <?php if($prods && $prods->num_rows > 0): ?>
            <?php while($row = $prods->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product">
                    <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                    <div class="product-price"><?php echo htmlspecialchars($row['price']); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: span 4; text-align:center; color:#999; font-style:italic;">Chưa có sản phẩm nào được thêm hệ thống.</div>
        <?php endif; ?>
    </div>

</body>
</html>
<?php include 'db.php'; 
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản Phẩm | AVG-STORE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background: #fff; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 8%; border-bottom: 1px solid #f2f2f2; background: #fff; }
        .logo { font-size: 24px; font-weight: bold; letter-spacing: 2px; text-decoration: none; color: #000; }
        .nav-links { display: flex; gap: 35px; list-style: none; }
        .nav-links a { text-decoration: none; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; }
        .nav-links a:hover, .nav-links a.active { color: #b38b6d; }
        .search-box { padding: 6px 12px; border: 1px solid #ddd; border-radius: 20px; outline: none; }
        .main-container { display: flex; padding: 40px 8%; gap: 50px; flex: 1; }
        .sidebar { width: 240px; flex-shrink: 0; }
        .filter-section { margin-bottom: 30px; }
        .filter-title { font-size: 14px; font-weight: 700; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .filter-section label { display: flex; align-items: center; margin-bottom: 12px; font-size: 14px; color: #555; cursor: pointer; }
        .filter-section input { margin-right: 10px; width: 16px; height: 16px; accent-color: #b38b6d; }
        .content-area { flex: 1; }
        .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .product-card { background: #fff; display: flex; flex-direction: column; }
        .img-holder { width: 100%; height: 350px; background: #f7f7f7; overflow: hidden; margin-bottom: 15px; border: 1px solid #f2f2f2; }
        .img-holder img { width: 100%; height: 100%; object-fit: cover; }
        .category-lbl { font-size: 11px; color: #999; text-transform: uppercase; }
        .product-title { font-size: 14px; color: #222; font-weight: 500; text-decoration: none; margin: 5px 0; }
        .price-lbl { font-size: 14px; color: #b38b6d; font-weight: 600; margin-bottom: 10px; }
        .add-btn { background: #111; color: #fff; border: none; padding: 10px; font-size: 11px; font-weight: 600; text-transform: uppercase; cursor: pointer; }
        .add-btn:hover { background: #b38b6d; }
        .no-msg { grid-column: span 3; text-align: center; padding: 40px; color: #888; display: none; }
        .pagination { display: flex; justify-content: center; gap: 5px; margin-top: 30px; }
        .page-node { padding: 8px 14px; border: 1px solid #ddd; cursor: pointer; user-select: none; }
        .page-node:hover, .page-node.active { background: #111; color: #fff; border-color: #111; }
        .page-node.disabled { opacity: 0.3; pointer-events: none; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="logo">AVG-STORE</a>
        <ul class="nav-links">
            <li><a href="index.php">TRANG CHỦ</a></li>
            <li><a href="products.php" class="active">SẢN PHẨM</a></li>
            <li><a href="contact.php">LIÊN HỆ</a></li>
            <?php if(isset($_SESSION['user'])): ?>
                <li><a href="logout.php">ĐĂNG XUẤT</a></li>
            <?php else: ?>
                <li><a href="login.php">ĐĂNG NHẬP</a></li>
            <?php endif; ?>
        </ul>
        <input type="text" class="search-box" id="searchField" placeholder="Tìm kiếm..." onkeyup="filterData(true)">
    </div>

    <div class="main-container">
        <div class="sidebar">
            <div class="filter-section">
                <div class="filter-title">Danh Mục</div>
                <label><input type="checkbox" class="cat-cb" value="áo sơ mi & blazer" onchange="filterData(true)"> Áo Sơ Mi & Blazer</label>
                <label><input type="checkbox" class="cat-cb" value="váy & đầm" onchange="filterData(true)"> Váy & Đầm</label>
                <label><input type="checkbox" class="cat-cb" value="quần & chân váy" onchange="filterData(true)"> Quần & Chân Váy</label>
                <label><input type="checkbox" class="cat-cb" value="phụ kiện" onchange="filterData(true)"> Phụ Kiện</label>
            </div>
            <div class="filter-section">
                <div class="filter-title">Khoảng Giá</div>
                <label><input type="checkbox" class="price-cb" value="under1m" onchange="filterData(true)"> Dưới 1.000.000đ</label>
                <label><input type="checkbox" class="price-cb" value="1mto1m5" onchange="filterData(true)"> 1.000.000đ - 1.500.000đ</label>
                <label><input type="checkbox" class="price-cb" value="over1m5" onchange="filterData(true)"> Trên 1.500.000đ</label>
            </div>
        </div>

        <div class="content-area">
            <div class="products-grid" id="gridContainer">
                <?php while($row = $result->fetch_assoc()): 
                    $clean_price = (int)preg_replace('/[^0-9]/', '', $row['price']);
                    $clean_cat = mb_strtolower(trim($row['category']), 'UTF-8');
                ?>
                    <div class="product-card" data-category="<?php echo $clean_cat; ?>" data-price="<?php echo $clean_price; ?>">
                        <div class="img-holder"><img src="<?php echo $row['image']; ?>" onerror="this.src='https://placehold.co/300x350'"></div>
                        <span class="category-lbl"><?php echo $row['category']; ?></span>
                        <a href="#" class="product-title"><?php echo $row['name']; ?></a>
                        <span class="price-lbl"><?php echo $row['price']; ?></span>
                        <button class="add-btn">Thêm vào giỏ</button>
                    </div>
                <?php endwhile; ?>
                <div class="no-msg" id="noDataNotify">Không tìm thấy sản phẩm phù hợp.</div>
            </div>
            <div class="pagination" id="paginationBox"></div>
        </div>
    </div>

    <script>
        const PER_PAGE = 6; let currPage = 1;
        function filterData(reset = false) {
            if(reset) currPage = 1;
            let search = document.getElementById('searchField').value.toLowerCase().trim();
            let cats = Array.from(document.querySelectorAll('.cat-cb:checked')).map(cb => cb.value.toLowerCase().trim());
            let prices = Array.from(document.querySelectorAll('.price-cb:checked')).map(cb => cb.value);
            let cards = Array.from(document.querySelectorAll('.product-card'));
            let matchCards = [];

            cards.forEach(card => {
                let cCat = card.getAttribute('data-category') || "";
                let cPrice = parseInt(card.getAttribute('data-price')) || 0;
                let cName = card.querySelector('.product-title').innerText.toLowerCase();
                
                let mSearch = cName.includes(search);
                let mCat = cats.length === 0 || cats.some(c => cCat.includes(c));
                let mPrice = false;
                
                if(prices.length === 0) mPrice = true;
                else {
                    prices.forEach(p => {
                        if(p==='under1m' && cPrice < 1000000) mPrice = true;
                        if(p==='1mto1m5' && cPrice >= 1000000 && cPrice <= 1500000) mPrice = true;
                        if(p==='over1m5' && cPrice > 1500000) mPrice = true;
                    });
                }
                if(mSearch && mCat && mPrice) { matchCards.push(card); } 
                else { card.style.display = 'none'; }
            });

            document.getElementById('noDataNotify').style.display = matchCards.length===0 ? 'block' : 'none';
            if(matchCards.length === 0) { document.getElementById('paginationBox').innerHTML = ''; return; }
            
            let total = Math.ceil(matchCards.length / PER_PAGE);
            let start = (currPage - 1) * PER_PAGE, end = start + PER_PAGE;
            matchCards.forEach((c, i) => { c.style.display = (i >= start && i < end) ? 'flex' : 'none'; });
            
            let pgHtml = `<span class="page-node ${currPage===1?'disabled':''}" onclick="changePg(${currPage-1})">«</span>`;
            for(let i=1; i<=total; i++) { pgHtml += `<span class="page-node ${currPage===i?'active':''}" onclick="changePg(${i})">${i}</span>`; }
            pgHtml += `<span class="page-node ${currPage===total?'disabled':''}" onclick="changePg(${currPage+1})">»</span>`;
            document.getElementById('paginationBox').innerHTML = total > 1 ? pgHtml : '';
        }
        function changePg(p) { currPage = p; filterData(false); window.scrollTo({top:0, behavior:'smooth'}); }
        window.addEventListener('DOMContentLoaded', () => filterData(false));
    </script>
</body>
</html>
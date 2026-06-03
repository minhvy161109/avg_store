<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền Admin chính xác
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "avg_store");
if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$msg = "";

// --- XỬ LÝ ĐỔ DỮ LIỆU CŨ LÊN FORM KHI ẤN NÚT "SỬA" ---
$edit_id = "";
$edit_name = "";
$edit_category = "";
$edit_price = "";
$edit_image = "";
$is_edit_mode = false;

if (isset($_GET['edit_product_id'])) {
    $edit_id = intval($_GET['edit_product_id']);
    $edit_res = $conn->query("SELECT * FROM products WHERE id = $edit_id");
    if ($edit_res && $edit_res->num_rows > 0) {
        $edit_row = $edit_res->fetch_assoc();
        $edit_name = $edit_row['name'];
        $edit_category = $edit_row['category'];
        $edit_price = $edit_row['price'];
        $edit_image = $edit_row['image'];
        $is_edit_mode = true;
    }
}

// --- XỬ LÝ CẬP NHẬT SẢN PHẨM ---
if (isset($_POST['update_product'])) {
    $id = intval($_POST['p_id']);
    $name = trim($_POST['p_name']);
    $category = $_POST['p_category'];
    $price = trim($_POST['p_price']);
    $image = trim($_POST['p_image']);
    
    if (!empty($name) && !empty($price)) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $category, $price, $image, $id);
        if ($stmt->execute()) {
            $msg = "<p style='color:green; text-align:center; margin-bottom:15px; font-weight:bold;'>Cập nhật sản phẩm thành công!</p>";
        } else {
            $msg = "<p style='color:red; text-align:center; margin-bottom:15px;'>Lỗi cập nhật sản phẩm.</p>";
        }
        $stmt->close();
    }
}

// --- XỬ LÝ THÊM SẢN PHẨM MỚI ---
if (isset($_POST['add_product'])) {
    $name = trim($_POST['p_name']);
    $category = $_POST['p_category'];
    $price = trim($_POST['p_price']);
    $image = trim($_POST['p_image']);
    
    if (!empty($name) && !empty($price)) {
        $stmt = $conn->prepare("INSERT INTO products (name, category, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $category, $price, $image);
        if ($stmt->execute()) {
            $msg = "<p style='color:green; text-align:center; margin-bottom:15px; font-weight:bold;'>Thêm sản phẩm thành công!</p>";
        } else {
            $msg = "<p style='color:red; text-align:center; margin-bottom:15px;'>Lỗi thêm sản phẩm.</p>";
        }
        $stmt->close();
    }
}

// --- XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG ---
if (isset($_POST['update_order_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['order_status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    if ($stmt->execute()) {
        $msg = "<p style='color:green; text-align:center; margin-bottom:15px; font-weight:bold;'>Cập nhật trạng thái đơn hàng thành công!</p>";
    }
    $stmt->close();
}

// --- XỬ LÝ CẤP TÀI KHOẢN NHÂN VIÊN ---
if (isset($_POST['add_user'])) {
    $u_name = trim($_POST['u_username']);
    $u_pass = trim($_POST['u_password']);
    $u_role = 'admin';
    
    if (!empty($u_name) && !empty($u_pass)) {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $u_name, $u_pass, $u_role);
        if ($stmt->execute()) {
            $msg = "<p style='color:green; text-align:center; margin-bottom:15px; font-weight:bold;'>Cấp tài khoản thành công!</p>";
        } else {
            $msg = "<p style='color:red; text-align:center; margin-bottom:15px;'>Tài khoản đã tồn tại hoặc lỗi hệ thống.</p>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Trị | AVG-STORE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f5f7fb; color: #333; padding: 30px 3%; }
        h1 { text-align: center; font-size: 22px; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px; }
        .admin-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px; margin-bottom: 30px; }
        @media (max-width: 950px) { .admin-grid { grid-template-columns: 1fr; } }
        .card { background: #fff; border: 1px solid #e2e8f0; padding: 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .card.full-width { grid-column: 1 / -1; }
        .card h2 { font-size: 14px; text-transform: uppercase; border-bottom: 2px solid #111; padding-bottom: 8px; margin-bottom: 20px; letter-spacing: 0.5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 10px; font-size: 13px; border: 1px solid #ccc; border-radius: 4px; outline: none; }
        .btn-action { padding: 9px 18px; background: #111; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-transform: uppercase; font-size: 11px; font-weight: bold; }
        .btn-action:hover { background: #b38b6d; }
        .btn-cancel { padding: 9px 15px; background: #dc3545; color: #fff; text-decoration: none; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; margin-left: 10px; }
        .btn-edit-link { display: inline-block; padding: 4px 8px; background: #e2e8f0; color: #1e293b; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-edit-link:hover { background: #b38b6d; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px; }
        table th, table td { padding: 12px 10px; border: 1px solid #eee; text-align: left; }
        table th { background: #fafafa; font-weight: bold; }
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .status-wait { background: #fff7ed; color: #c2410c; }
        .status-shipping { background: #eff6ff; color: #1d4ed8; }
        .status-done { background: #ecfdf5; color: #047857; }
    </style>
</head>
<body>

    <h1>Hệ Thống Quản Trị | AVG-STORE</h1>
    
    <?php if(!empty($msg)) echo $msg; ?>

    <div class="card full-width" style="margin-bottom: 30px;">
        <h2>Quản Lý Đơn Hàng Từ Khách Hàng</h2>
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ Nhận Hàng</th>
                    <th>Sản Phẩm Mua</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $o_res = $conn->query("SELECT * FROM orders ORDER BY id DESC");
                if($o_res && $o_res->num_rows > 0){
                    while($orow = $o_res->fetch_assoc()){
                        // Tạo class màu sắc cho từng trạng thái đơn hàng
                        $badge_class = 'status-wait';
                        if($orow['status'] == 'Đang giao') $badge_class = 'status-shipping';
                        if($orow['status'] == 'Đã hoàn thành') $badge_class = 'status-done';

                        echo "<tr>
                                <td><b>#".$orow['id']."</b></td>
                                <td>".htmlspecialchars($orow['customer_name'])."</td>
                                <td>".htmlspecialchars($orow['phone'])."</td>
                                <td>".htmlspecialchars($orow['address'])."</td>
                                <td>".htmlspecialchars($orow['product_name'])."</td>
                                <td><span style='color:#b38b6d; font-weight:bold;'>".$orow['total_price']."</span></td>
                                <td><span class='status-badge ".$badge_class."'>".$orow['status']."</span></td>
                                <td>
                                    <form method='POST' action='admin.php' style='display:flex; gap:5px;'>
                                        <input type='hidden' name='order_id' value='".$orow['id']."'>
                                        <select name='order_status' style='padding:4px; font-size:12px; width:110px;'>
                                            <option value='Chờ xử lý' ".($orow['status'] == 'Chờ xử lý' ? 'selected' : '').">Chờ xử lý</option>
                                            <option value='Đang giao' ".($orow['status'] == 'Đang giao' ? 'selected' : '').">Đang giao</option>
                                            <option value='Đã hoàn thành' ".($orow['status'] == 'Đã hoàn thành' ? 'selected' : '').">Đã hoàn thành</option>
                                        </select>
                                        <button type='submit' name='update_order_status' class='btn-action' style='padding:4px 8px; font-size:11px;'>Cập Nhật</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center; color:#aaa;'>Chưa có đơn hàng nào được đặt.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="admin-grid">
        <div class="card">
            <h2><?php echo $is_edit_mode ? 'Sửa Chỉnh Sửa Sản Phẩm' : 'Quản Lý Sản Phẩm'; ?></h2>
            <form method="POST" action="admin.php">
                <input type="hidden" name="p_id" value="<?php echo $edit_id; ?>">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="p_name" required value="<?php echo htmlspecialchars($edit_name); ?>" placeholder="Ví dụ: ĐẦM DÁNG NGẮN TAY BỒNG...">
                </div>
                <div class="form-group">
                    <label>Danh mục sản phẩm</label>
                    <select name="p_category">
                        <option value="Áo Sơ Mi & Blazer" <?php if($edit_category == 'Áo Sơ Mi & Blazer') echo 'selected'; ?>>Áo Sơ Mi & Blazer</option>
                        <option value="Váy & Đầm" <?php if($edit_category == 'Váy & Đầm') echo 'selected'; ?>>Váy & Đầm</option>
                        <option value="Quần & Chân Váy" <?php if($edit_category == 'Quần & Chân Váy') echo 'selected'; ?>>Quần & Chân Váy</option>
                        <option value="Phụ Kiện" <?php if($edit_category == 'Phụ Kiện') echo 'selected'; ?>>Phụ Kiện</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Giá hiển thị</label>
                    <input type="text" name="p_price" required value="<?php echo htmlspecialchars($edit_price); ?>" placeholder="Ví dụ: 1.200.000 VND">
                </div>
                <div class="form-group">
                    <label>Đường dẫn hình ảnh</label>
                    <input type="text" name="p_image" value="<?php echo htmlspecialchars($edit_image); ?>" placeholder="Nhập link ảnh hoặc tên file ảnh...">
                </div>

                <?php if ($is_edit_mode): ?>
                    <button type="submit" name="update_product" class="btn-action">Cập Nhật Sản Phẩm</button>
                    <a href="admin.php" class="btn-cancel">Hủy</a>
                <?php else: ?>
                    <button type="submit" name="add_product" class="btn-action">Thêm vào hệ thống</button>
                <?php endif; ?>
            </form>

            <h2 style="margin-top:40px;">Danh Sách Sản Phẩm Hiện Tại</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá tiền</th>
                        <th style="text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $p_res = $conn->query("SELECT * FROM products ORDER BY id DESC");
                    if($p_res && $p_res->num_rows > 0){
                        while($row = $p_res->fetch_assoc()){
                            echo "<tr>
                                    <td>".htmlspecialchars($row['name'])."</td>
                                    <td>".htmlspecialchars($row['category'])."</td>
                                    <td>".htmlspecialchars($row['price'])."</td>
                                    <td style='text-align: center;'>
                                        <a href='admin.php?edit_product_id=".$row['id']."' class='btn-edit-link'>Sửa</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center; color:#aaa;'>Chưa có sản phẩm nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Quản Lý Nhân Viên (Chỉ Admin)</h2>
            <form method="POST" action="admin.php">
                <div class="form-group">
                    <label>Tên đăng nhập nhân viên</label>
                    <input type="text" name="u_username" required placeholder="Nhập tài khoản nhân viên mới...">
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="u_password" required placeholder="••••••">
                </div>
                <button type="submit" name="add_user" class="btn-action">Cấp tài khoản</button>
            </form>

            <h2 style="margin-top:40px;">Danh Sách Quản Trị Viên</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Tài Khoản</th>
                        <th>Chức Vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $u_res = $conn->query("SELECT id, username, role FROM users WHERE role = 'admin'");
                    if($u_res && $u_res->num_rows > 0){
                        while($urow = $u_res->fetch_assoc()){
                            echo "<tr>
                                    <td>".$urow['id']."</td>
                                    <td>".htmlspecialchars($urow['username'])."</td>
                                    <td>".htmlspecialchars($urow['role'])."</td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <div style="margin-top: 30px; text-align: right;">
                <a href="index.php" style="font-size:13px; color:#555; text-decoration:none; font-weight:bold;">← Về Trang Chủ</a>
            </div>
        </div>
    </div>

</body>
</html>
<h2 style="margin-top:40px;">Hành động khác</h2>
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <a href="index.php" style="flex: 1; padding: 10px; background: #e2e8f0; color: #333; text-decoration: none; text-align: center; border-radius: 4px; font-size: 12px; font-weight: bold;">← Về Trang Chủ</a>
                
                <a href="logout.php" style="flex: 1; padding: 10px; background: #dc3545; color: white; text-decoration: none; text-align: center; border-radius: 4px; font-size: 12px; font-weight: bold;">Đăng Xuất</a>
            </div>
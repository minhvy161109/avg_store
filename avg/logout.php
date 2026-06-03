<?php
// Bắt đầu session để có quyền can thiệp vào dữ liệu người dùng đang lưu
session_start();

// Hủy toàn bộ dữ liệu session (tên đăng nhập, quyền admin,...)
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập
header("Location: login.php");
exit();
?>
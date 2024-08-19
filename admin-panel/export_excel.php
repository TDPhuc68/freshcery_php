<?php
global $conn;
require "../config/config.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Truy vấn doanh thu theo tháng
$revenueByMonth = $conn->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as order_month, SUM(price) as total_revenue 
    FROM orders 
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY order_month ASC
");
$revenueByMonth->execute();
$revenues = $revenueByMonth->fetchAll(PDO::FETCH_OBJ);

// Truy vấn số lượng đơn hàng theo tháng từ bảng orders
$ordersByMonth = $conn->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as order_month, COUNT(*) as total_orders 
    FROM orders 
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY order_month ASC
");
$ordersByMonth->execute();
$ordersCount = $ordersByMonth->fetchAll(PDO::FETCH_OBJ);

// Tạo mới một Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tiêu đề cho các cột
$sheet->setCellValue('A1', 'Tháng');
$sheet->setCellValue('B1', 'Doanh thu');
$sheet->setCellValue('C1', 'Số lượng đơn hàng');

// Điền dữ liệu vào các cột
$row = 2; // Bắt đầu từ dòng thứ 2
foreach ($revenues as $index => $revenue) {
    $sheet->setCellValue('A' . $row, $revenue->order_month);
    $sheet->setCellValue('B' . $row, $revenue->total_revenue);
    $sheet->setCellValue('C' . $row, $ordersCount[$index]->total_orders);
    $row++;
}

// Đặt tên file và lưu file Excel
$filename = 'BaoCaoDoanhThu_' . date('Y-m-d') . '.xlsx';
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save("php://output");
exit;
?>

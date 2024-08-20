<?php
require "../../config/config.php";
require "../../vendor/autoload.php";  // Đảm bảo đường dẫn chính xác đến autoload.php của Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(!isset($_GET['id'])) {
    die("ID đơn hàng không hợp lệ.");
}

$orderId = $_GET['id'];

// Truy vấn dữ liệu của đơn hàng dựa trên ID
$orderQuery = $conn->prepare("SELECT * FROM orders WHERE id = :id");
$orderQuery->execute(['id' => $orderId]);
$order = $orderQuery->fetch(PDO::FETCH_OBJ);

if(!$order) {
    die("Không tìm thấy đơn hàng.");
}

// Tạo một file Excel mới
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tiêu đề cho các cột
$sheet->setCellValue('A1', 'Hoa Đơn');
$sheet->setCellValue('A3', 'Order ID');
$sheet->setCellValue('B3', $order->id);
$sheet->setCellValue('A4', 'First Name');
$sheet->setCellValue('B4', $order->name);
$sheet->setCellValue('A5', 'Last Name');
$sheet->setCellValue('B5', $order->lname);
$sheet->setCellValue('A6', 'Email');
$sheet->setCellValue('B6', $order->email);
$sheet->setCellValue('A7', 'Country');
$sheet->setCellValue('B7', $order->country);
$sheet->setCellValue('A8', 'Status');
$sheet->setCellValue('B8', $order->status);
$sheet->setCellValue('A9', 'Price in USD');
$sheet->setCellValue('B9', $order->price);
$sheet->setCellValue('A10', 'Date');
$sheet->setCellValue('B10', $order->created_at);

// Đặt tên file và lưu file Excel
$filename = 'Invoice_Order_' . $order->id . '.xlsx';
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save("php://output");
exit;
?>

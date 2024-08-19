<?php
global $conn;
require "layouts/header.php";
require "../config/config.php";

if(!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

//products
$products = $conn->query("SELECT COUNT(*) as products_num FROM products");
$products->execute();
$num_products = $products->fetch(PDO::FETCH_OBJ);

//orders
$orders = $conn->query("SELECT COUNT(*) as orders_num FROM orders");
$orders->execute();
$num_orders = $orders->fetch(PDO::FETCH_OBJ);

//categories
$categories = $conn->query("SELECT COUNT(*) as categories_num FROM categories");
$categories->execute();
$num_categories = $categories->fetch(PDO::FETCH_OBJ);

//admins
$admins = $conn->query("SELECT COUNT(*) as admins_num FROM admins");
$admins->execute();
$num_admins = $admins->fetch(PDO::FETCH_OBJ);

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

// Chuẩn bị dữ liệu cho biểu đồ doanh thu theo tháng
$months = [];
$revenuesData = [];
foreach ($revenues as $revenue) {
    $months[] = $revenue->order_month;
    $revenuesData[] = $revenue->total_revenue;
}

// Chuẩn bị dữ liệu cho biểu đồ số lượng đơn hàng theo tháng
$ordersData = [];
foreach ($ordersCount as $order) {
    $ordersData[] = $order->total_orders;
}
?>

<style>
    .row {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
    }

    .col-md-3 {
        flex: 1;
        max-width: 23%;
        margin: 10px;
    }

    .card {
        background-color: rgba(21, 175, 93, 0.94);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 25px;
        font-weight: bold;
        color: rgba(9, 126, 126, 0.94);
        margin-bottom: 15px;
    }

    .card-text {
        font-size: 20px;
        color: rgba(21, 174, 175, 0.94);
    }

    /* Màu nền cho các hàng khác nhau */
    .row:nth-child(1) .card {
        background-color: rgba(6, 32, 33, 0.94); /* Hồng nhạt cho Products */
    }

    .row:nth-child(2) .card {
        background-color: rgba(41, 227, 171, 0.94); /* Xanh nhạt cho Orders */
    }

    .row:nth-child(3) .card {
        background-color: #d21010; /* Vàng nhạt cho Categories */
    }

    .row:nth-child(4) .card {
        background-color: #d1f1f1; /* Xanh lam nhạt cho Admins */
    }

    /* Tối ưu cho thiết bị di động */
    @media (max-width: 768px) {
        .col-md-3 {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .row {
            flex-direction: column;
            align-items: center;
        }
    }

    /* Styles cho biểu đồ */
    #revenueChartContainer, #ordersChartContainer {
        width: 100%; /* Cùng kích thước cho cả hai biểu đồ */
        margin: 20px auto;
    }
</style>

<!-- Phần hiển thị hai biểu đồ ngang bằng nhau -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Doanh thu theo tháng</h5>
                <div id="revenueChartContainer">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Số lượng đơn hàng theo tháng</h5>
                <div id="ordersChartContainer">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ tròn doanh thu theo tháng
    var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctxRevenue, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($months); ?>, // Tháng
            datasets: [{
                label: 'Doanh thu theo tháng',
                data: <?php echo json_encode($revenuesData); ?>, // Doanh thu
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#cc65fe',
                    '#ffce56',
                    '#2e93f9',
                    '#2ed8b6',
                    '#ff5252'
                ],
                borderColor: [
                    '#fff'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Thống kê doanh thu theo tháng'
                }
            }
        }
    });

    // Biểu đồ cột số lượng đơn hàng theo tháng
    var ctxOrders = document.getElementById('ordersChart').getContext('2d');
    var ordersChart = new Chart(ctxOrders, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>, // Tháng
            datasets: [{
                label: 'Số lượng đơn hàng',
                data: <?php echo json_encode($ordersData); ?>, // Số lượng đơn hàng
                backgroundColor: '#36a2eb',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Thống kê số lượng đơn hàng theo tháng'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    });
</script>


<script type="module" defer crossorigin data-id="2af3b89f-f2ae-4efe-87e1-fb18eb6e1456" data-name="MantaAssistant" src="https://barnaclestudios.com/js/scripts/site/chat/externalassistant.js"></script>

<div class="row">
    <div class="col-md-12 text-center">
        <form action="export_excel.php" method="POST">
            <button type="submit" class="btn btn-success">Xuất Excel</button>
        </form>
    </div>
</div>

<?php require "layouts/footer.php"; ?>

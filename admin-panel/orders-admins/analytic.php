<?php
global $conn;
require "../layouts/header.php";
require "../../config/config.php";

if(!isset($_SESSION['adminname'])) {
    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";
}

// Truy vấn khách hàng tiềm năng (Top 5 khách hàng theo số lượng đơn hàng và tổng giá trị)
$potentialCustomersQuery = $conn->query("
    SELECT name, lname, email, COUNT(*) as total_orders, SUM(price) as total_spent 
    FROM orders 
    GROUP BY name, lname, email
    ORDER BY total_orders DESC, total_spent DESC 
    LIMIT 5
");
$potentialCustomersQuery->execute();
$potentialCustomers = $potentialCustomersQuery->fetchAll(PDO::FETCH_OBJ);

// Tính toán điểm tiềm năng
foreach ($potentialCustomers as $customer) {
    $customer->potential_score = ($customer->total_orders * 2) + ($customer->total_spent / 100);
}

// Phân tích khách hàng đứng đầu, đứng giữa và đứng cuối
$topCustomer = $potentialCustomers[0];
$middleCustomer = $potentialCustomers[(int)(count($potentialCustomers) / 2)];
$bottomCustomer = end($potentialCustomers);
?>

<style>
    .top-customer {
        background-color: #c6efce;
        color: #006100;
        font-weight: bold;
    }

    .middle-customer {
        background-color: #ffeb9c;
        color: #9c6500;
        font-weight: bold;
    }

    .bottom-customer {
        background-color: #ffc7ce;
        color: #9c0006;
        font-weight: bold;
    }
</style>

<!-- Phần hiển thị hệ thống đánh giá khách hàng tiềm năng -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hệ thống đánh giá khách hàng tiềm năng</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Total Orders</th>
                        <th scope="col">Total Spent (USD)</th>
                        <th scope="col">Potential Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($potentialCustomers as $index => $customer) : ?>
                        <tr class="<?php
                        if ($customer === $topCustomer) echo 'top-customer';
                        elseif ($customer === $middleCustomer) echo 'middle-customer';
                        elseif ($customer === $bottomCustomer) echo 'bottom-customer';
                        ?>">
                            <td><?php echo htmlspecialchars($customer->name); ?></td>
                            <td><?php echo htmlspecialchars($customer->lname); ?></td>
                            <td><?php echo htmlspecialchars($customer->email); ?></td>
                            <td><?php echo $customer->total_orders; ?></td>
                            <td><?php echo $customer->total_spent; ?></td>
                            <td><?php echo number_format($customer->potential_score, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Phần phân tích khách hàng -->
<div class="row">
    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Phân tích khách hàng tiềm năng</h5>
                <p><strong class="top-customer">Khách hàng đứng đầu:</strong> <?php echo htmlspecialchars($topCustomer->name . ' ' . $topCustomer->lname); ?> có số lượng đơn hàng là <?php echo $topCustomer->total_orders; ?> và tổng chi tiêu là $<?php echo number_format($topCustomer->total_spent, 2); ?>. Đây là khách hàng có giá trị cao nhất, nên tiếp tục duy trì và phát triển mối quan hệ với họ.</p>
                <p><strong class="middle-customer">Khách hàng đứng giữa:</strong> <?php echo htmlspecialchars($middleCustomer->name . ' ' . $middleCustomer->lname); ?> có số lượng đơn hàng là <?php echo $middleCustomer->total_orders; ?> và tổng chi tiêu là $<?php echo number_format($middleCustomer->total_spent, 2); ?>. Họ có tiềm năng phát triển nếu được chăm sóc và khuyến khích đúng cách.</p>
                <p><strong class="bottom-customer">Khách hàng đứng cuối:</strong> <?php echo htmlspecialchars($bottomCustomer->name . ' ' . $bottomCustomer->lname); ?> có số lượng đơn hàng là <?php echo $bottomCustomer->total_orders; ?> và tổng chi tiêu là $<?php echo number_format($bottomCustomer->total_spent, 2); ?>. Cần có các chiến lược đặc biệt để giữ chân khách hàng này.</p>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>

<?php global $conn;
require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
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
</style>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <p class="card-text">number of products: <?php echo $num_products->products_num; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <p class="card-text">number of orders: <?php echo $num_orders->orders_num; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <p class="card-text">number of categories: <?php echo $num_categories->categories_num; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Admins</h5>
                <p class="card-text">number of admins: <?php echo $num_admins->admins_num; ?></p>
            </div>
        </div>
    </div>
</div>

<?php require "layouts/footer.php"; ?>

<?php global $conn;
require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 

  if(!isset($_SESSION['adminname'])) {
          
    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";

  }
  
  $products = $conn->query("SELECT * FROM products");
  $products->execute();

  $allProducts = $products->fetchAll(PDO::FETCH_OBJ);


?>
<style>
    /* Tổng thể */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Căn chỉnh hàng và cột */
    .row {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .col {
        max-width: 90%;
    }

    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #ffffff;
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Bảng */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: #ffffff;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #bd9f0a;
        color: #ffffff;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color: #e9ecef;
    }

    /* Tối ưu cho thiết bị di động */
    @media (max-width: 768px) {
        .col {
            max-width: 100%;
            padding: 0 15px;
        }

        .table {
            width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }
    }

</style>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Products</h5>
              <a  href="<?php echo ADMINURL; ?>/products-admins/create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">product</th>
                    <th scope="col">price in $$</th>
                    <th scope="col">expiration date</th>
                    <th scope="col">status</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($allProducts as $product) : ?> 
                    <tr>
                      <th scope="row"><?php echo $product->id; ?></th>
                      <td><?php echo $product->title; ?></td>
                      <td><?php echo $product->price; ?></td>
                      <td><?php echo $product->exp_date; ?></td>
                      <?php if($product->status == 0) : ?>
                        <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&status=<?php echo $product->status; ?>" class="btn btn-danger  text-center ">unavailable</a></td>
                      <?php else : ?>
                        <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&status=<?php echo $product->status; ?>" class="btn btn-success  text-center ">available</a></td>
                      <?php endif; ?>  
                      <td><a href="<?php echo ADMINURL; ?>/products-admins/delete-products.php?id=<?php echo $product->id; ?>" class="btn btn-danger  text-center ">delete</a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



<?php require "../layouts/footer.php"; ?>

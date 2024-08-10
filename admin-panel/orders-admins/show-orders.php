<?php global $conn;
require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

  if(!isset($_SESSION['adminname'])) {
          
    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";

  }
  
  $orders = $conn->query("SELECT * FROM orders");
  $orders->execute();

  $allOrders = $orders->fetchAll(PDO::FETCH_OBJ);


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

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #ffffff;
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
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
        background-color: #0c968b;
        color: #ffffff;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color:

</style>
    <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Orders</h5>
              <table class="table mt-3">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">first name</th>
                    <th scope="col">last name</th>
                    <th scope="col">email</th>
                    <th scope="col">country</th>
                    <th scope="col">status</th>
                    <th scope="col">price in USD</th>
                    <th scope="col">date</th>
                    <th scope="col">update</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allOrders as $order) : ?>
                    <tr>
                      <th scope="row"><?php echo $order->id; ?></th>
                      <td><?php echo $order->name; ?></td>
                      <td><?php echo $order->lname; ?></td>
                      <td><?php echo $order->email; ?></td>
                      <td><?php echo $order->country; ?></td>
                      <td><?php echo $order->status; ?></td>
                      <td><?php echo $order->price; ?></td>
                      <td><?php echo $order->created_at; ?></td>
                      <td>                
                          <a href="<?php echo ADMINURL; ?>/orders-admins/update-orders.php?id=<?php echo $order->id; ?>" class="btn btn-warning text-white mb-4 text-center">update</a>
                      </td>
                      <td><a href="delete-orders.php?id=<?php echo $order->id; ?>" class="btn btn-danger  text-center ">delete </a></td>

                    </tr>
                  <?php endforeach; ?>
              
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



 <?php require "../layouts/footer.php"; ?>

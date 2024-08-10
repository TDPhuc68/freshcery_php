<?php global $conn;
require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

  if(!isset($_SESSION['adminname'])) {
          
    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";

  }
  
  $categories = $conn->query("SELECT * FROM categories");
  $categories->execute();

  $allCategories = $categories->fetchAll(PDO::FETCH_OBJ);


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
        background-color: #031426;
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
              <h5 class="card-title mb-4 d-inline">Categories</h5>
             <a  href="<?php echo ADMINURL; ?>/categories-admins/create-category.php" class="btn btn-primary mb-4 text-center float-right">Create Categories</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">update</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allCategories as $category) : ?>
                    <tr>
                      <th scope="row"><?php echo  $category->id; ?></th>
                      <td><?php echo  $category->name; ?></td>
                      <td><a  href="update-category.php?id=<?php echo $category->id; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                      <td><a href="delete-category.php?id=<?php echo $category->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                    </tr>
                  <?php endforeach; ?>
               
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>


 <?php require "../layouts/footer.php"; ?>

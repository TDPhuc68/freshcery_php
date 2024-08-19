<?php global $conn;
require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if(!isset($_SESSION['adminname'])) {

    echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php'; </script>";

}
$admins = $conn->query("SELECT * FROM admins");
$admins->execute();

$allAdmins = $admins->fetchAll(PDO::FETCH_OBJ);

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

    .btn {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
        border-color: #0056b3;
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
        background-color: #09a6a1;
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
                <h5 class="card-title mb-4 d-inline">Admins</h5>
                <a  href="<?php echo ADMINURL; ?>/admins/create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">adminname</th>
                        <th scope="col">email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($allAdmins as $admin)  : ?>
                        <tr>
                            <th scope="row"><?php echo $admin->id; ?></th>
                            <td><?php echo $admin->adminname; ?></td>
                            <td><?php echo $admin->email; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bắt đầu tích hợp chatbot -->



<!-- Thay thế đoạn mã này bằng mã thực sự từ nền tảng chatbot của bạn -->

<script type="module" defer crossorigin data-id="2af3b89f-f2ae-4efe-87e1-fb18eb6e1456" data-name="MantaAssistant" src="https://barnaclestudios.com/js/scripts/site/chat/externalassistant.js"></script>






<?php require "../layouts/footer.php"; ?>

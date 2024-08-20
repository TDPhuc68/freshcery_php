<div id="page-content" class="page-content">
    <div class="container">
        <h1 class="pt-5">Product Recommendation For Customer</h1>

        <!-- Form to search for products -->
        <div class="col-md-12 mt-4">
            <h4>Điều bạn cần:</h4>
            <form method="GET" action="recommend.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control custom-input" name="query" placeholder="Enter information or keywords..." aria-label="Search Products" aria-describedby="button-search" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary custom-button" type="submit" id="button-search">Recommend</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Tùy chỉnh kích thước và màu sắc khung nhập liệu */
    .custom-input {
        font-size: 1.25rem; /* Tăng kích thước chữ */
        padding: 15px; /* Tăng độ cao của khung nhập */
        border-radius: 8px; /* Bo tròn góc */
        border: 2px solid #1a9d99; /* Đường viền màu xanh */
    }

    /* Tùy chỉnh nút bấm */
    .custom-button {
        font-size: 1.25rem; /* Tăng kích thước chữ */
        padding: 12px 20px; /* Tăng kích thước nút bấm */
        background-color: rgba(11, 82, 82, 0.94); /* Màu nền xanh */
        color: #fff; /* Màu chữ trắng */
        border: none; /* Loại bỏ đường viền */
        border-radius: 8px; /* Bo tròn góc */
        transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu */
    }

    /* Hiệu ứng khi hover qua nút bấm */
    .custom-button:hover {
        background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
    }

    /* Đảm bảo rằng form và input không bị xếp chồng nhau */
    .input-group {
        max-width: 600px; /* Giới hạn độ rộng của form */
        margin: 0 auto; /* Canh giữa form */
    }
</style>

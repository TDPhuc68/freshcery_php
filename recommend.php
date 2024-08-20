<?php
require "includes/header.php";
require "config/config.php";
global $conn;

// Kiểm tra xem có từ khóa nào được nhập vào không
if (!isset($_GET['query']) || empty($_GET['query'])) {
    echo "<script>alert('Please enter a product name or keyword.'); window.location.href='".APPURL."/shop.php';</script>";
    exit;
}

$query = $_GET['query']; // Lấy từ khóa mà người dùng nhập vào

// Tìm kiếm tất cả các sản phẩm để tính toán độ tương đồng
$products = $conn->prepare("SELECT id, title, description, category_id, image, price FROM products WHERE status = 1");
$products->execute();
$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

// Kết hợp các trường thành một chuỗi duy nhất để tính toán tương đồng
$productFeatures = [];
foreach ($allProducts as $product) {
    $productFeatures[$product->id] = $product->title . ' ' . $product->description . ' ' . $product->category_id;
}

// Chuyển đổi văn bản thành vector
function text_to_vector($text) {
    $words = explode(' ', strtolower($text));
    $vector = [];
    foreach ($words as $word) {
        if (isset($vector[$word])) {
            $vector[$word] += 1;
        } else {
            $vector[$word] = 1;
        }
    }
    return $vector;
}

// Tính toán sự tương đồng cosine
function cosine_similarity($vec1, $vec2) {
    $dotProduct = 0.0;
    $normA = 0.0;
    $normB = 0.0;

    // Tìm các từ chung trong cả hai vector
    $allKeys = array_unique(array_merge(array_keys($vec1), array_keys($vec2)));

    foreach ($allKeys as $key) {
        $value1 = isset($vec1[$key]) ? $vec1[$key] : 0;
        $value2 = isset($vec2[$key]) ? $vec2[$key] : 0;

        $dotProduct += $value1 * $value2;
        $normA += $value1 * $value1;
        $normB += $value2 * $value2;
    }

    // Tránh chia cho 0 nếu một trong hai norm bằng 0
    if ($normA == 0 || $normB == 0) {
        return 0; // Trả về 0 nếu một trong hai vector không có giá trị
    }

    return $dotProduct / (sqrt($normA) * sqrt($normB));
}

// Tạo vector cho tất cả sản phẩm và từ khóa nhập vào
$queryVector = text_to_vector($query); // Chuyển từ khóa nhập vào thành vector
$productVectors = [];
foreach ($productFeatures as $id => $features) {
    $productVectors[$id] = text_to_vector($features);
}

// Tính toán sự tương đồng giữa từ khóa nhập vào và tất cả các sản phẩm
$similarityScores = [];
foreach ($productVectors as $id => $vector) {
    $similarityScores[$id] = cosine_similarity($queryVector, $vector);
}

// Sắp xếp các sản phẩm theo độ tương đồng giảm dần
arsort($similarityScores);

// Lấy ID của các sản phẩm có độ tương đồng cao nhất
$recommendedProductIds = array_keys(array_slice($similarityScores, 0, 3, true)); // Lấy 4 sản phẩm tương tự nhất

// Truy vấn các sản phẩm được gợi ý
if (!empty($recommendedProductIds)) {
    $placeholders = implode(',', array_fill(0, count($recommendedProductIds), '?'));
    $recommendedProductsQuery = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $recommendedProductsQuery->execute($recommendedProductIds);
    $recommendedProducts = $recommendedProductsQuery->fetchAll(PDO::FETCH_OBJ);
} else {
    $recommendedProducts = [];
}

?>

<div id="page-content" class="page-content">
    <div class="container">
        <h2>Recommended Products</h2>
        <div class="row">
            <?php if (!empty($recommendedProducts)): ?>
                <?php foreach ($recommendedProducts as $product): ?>
                    <div class="col-md-3">
                        <div class="product-item">
                            <img src="<?php echo IMGURLPRODUCT; ?>/<?php echo $product->image; ?>" width="200" height="200">
                            <h4><?php echo $product->title; ?></h4>
                            <p>Price: $<?php echo $product->price; ?></p>
                            <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo $product->id; ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info text-center">No recommendations available.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require "includes/footer.php"; ?>

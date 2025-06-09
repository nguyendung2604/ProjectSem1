<?php
// Kết nối database
require 'db_connect.php';

try {
    // Lấy ID sản phẩm từ URL
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($product_id <= 0) {
        throw new Exception("Invalid product ID.");
    }

    // Truy vấn chi tiết sản phẩm
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.name, p.description, p.price, p.quantity, b.name AS brand_name, pi.image_url
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        WHERE p.product_id = ?
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Product not found.");
    }
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Wireless World</title>
    <style>
        .product-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .product-details img {
            max-width: 300px;
            height: auto;
            border-radius: 5px;
        }
        .product-details h2 {
            font-size: 24px;
            margin: 10px 0;
        }
        .product-details p {
            margin: 10px 0;
            color: #555;
        }
        .price {
            font-weight: bold;
            color: #e44d26;
            font-size: 20px;
        }
        .stock {
            color: #28a745;
        }
        .out-of-stock {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <section class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <?php if ($product['image_url']): ?>
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <?php else: ?>
            <img src="default-image.jpg" alt="No image available">
        <?php endif; ?>
        <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
        <p class="price">$<?php echo number_format($product['price']); ?></p>
        <p class="<?php echo $product['quantity'] > 0 ? 'stock' : 'out-of-stock'; ?>">
            <?php echo $product['quantity'] > 0 ? 'In Stock: ' . $product['quantity'] : 'Out of Stock'; ?>
        </p>
        <?php if ($product['quantity'] > 0): ?>
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                <button type="submit">Add to Cart</button>
            </form>
        <?php else: ?>
            <p>Unavailable for purchase.</p>
        <?php endif; ?>
        <a href="products.php">Back to Products</a>
    </section>
</body>
</html>
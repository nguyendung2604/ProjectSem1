<?php
session_start();
require_once 'db_connect.php';

// Xử lý cập nhật/xóa sản phẩm trong giỏ hàng
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $qty;
        }
    }
}
if (isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    unset($_SESSION['cart'][$remove_id]);
}

// Lấy thông tin sản phẩm trong giỏ hàng
$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;
if (!empty($cart)) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $sql = "SELECT p.product_id, p.name, p.price, pi.image_url FROM products p
            LEFT JOIN product_images pi ON p.product_id = pi.product_id
            WHERE p.product_id IN ($ids) GROUP BY p.product_id";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as &$product) {
        $qty = $cart[$product['product_id']];
        $product['qty'] = $qty;
        $product['subtotal'] = $qty * $product['price'];
        $total += $product['subtotal'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Your Cart</h2>
    <?php if (empty($products)): ?>
        <div class="alert alert-info">Your cart is empty.</div>
    <?php else: ?>
    <form method="post">
    <table class="table align-middle table-bordered bg-white">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $item): ?>
            <tr>
                <td style="width:80px"><img src="<?= htmlspecialchars($item['image_url'] ?? 'HeroSection.jpg') ?>" width="60"></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>$<?= number_format($item['price']) ?></td>
                <td style="width:100px">
                    <input type="number" name="quantities[<?= $item['product_id'] ?>]" value="<?= $item['qty'] ?>" min="1" class="form-control form-control-sm">
                </td>
                <td>$<?= number_format($item['subtotal']) ?></td>
                <td>
                    <button name="remove" value="<?= $item['product_id'] ?>" class="btn btn-danger btn-sm">Remove</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total:</th>
                <th colspan="2">$<?= number_format($total) ?></th>
            </tr>
        </tfoot>
    </table>
    <div class="d-flex justify-content-between">
        <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
        <a href="#" class="btn btn-success">Checkout</a>
    </div>
    </form>
    <?php endif; ?>
    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

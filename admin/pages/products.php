<h2 class="mb-4">Product Management</h2>

<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.category_id 
                    LEFT JOIN brands b ON p.brand_id = b.brand_id
                    ORDER BY p.product_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $row):
            ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td>
                    <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                    <?php if (!empty($row['description'])): ?>
                    <small class="text-muted"><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></small>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge bg-success"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</span>
                </td>
                <td>
                    <span class="badge bg-<?php echo $row['quantity'] > 0 ? 'primary' : 'danger'; ?>">
                        <?php echo $row['quantity']; ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['brand_name'] ?? 'N/A'); ?></td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="delete_product" class="btn btn-danger-custom btn-sm btn-custom" 
                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                            <i class="fas fa-trash me-1"></i>Xóa
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
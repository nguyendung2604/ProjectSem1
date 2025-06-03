<h2 class="mb-4">Order Management</h2>
<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Truy vấn lấy danh sách đơn hàng kèm theo username từ bảng users
            $sql = "SELECT o.*, u.username as user_name 
                    FROM orders o 
                    LEFT JOIN users u ON o.user_id = u.id 
                    ORDER BY o.order_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orders as $row):
            ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td>
                    <span class="badge bg-success fs-6">
                        <?php echo number_format($row['total_price'], 0, ',', '.'); ?> VNĐ
                    </span>
                </td>
                <td>
                    <span class="badge bg-<?php echo $row['status'] === 'delivered' ? 'success' : 'warning'; ?>">
                        <?php
                        $status_text = [
                            'pending' => 'Đang chờ',
                            'delivered' => 'Đã giao'
                        ];
                        echo $status_text[$row['status']] ?? $row['status'];
                        ?>
                    </span>
                </td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <div class="input-group input-group-sm" style="width: 180px;">
                            <select name="status" class="form-select form-select-sm">
                                <option value="pending" <?php echo $row['status'] === 'pending' ? 'selected' : ''; ?>>Đang chờ</option>
                                <option value="delivered" <?php echo $row['status'] === 'delivered' ? 'selected' : ''; ?>>Đã giao</option>
                            </select>
                            <button type="submit" name="update_order_status" class="btn btn-primary-custom btn-sm">
                              <i class="bi bi-floppy-fill"></i>
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h2 class="mb-4">Category Management</h2>

<div class="form-container">
    <h5 class="mb-3">Thêm danh mục mới</h5>
    <form method="POST" class="row g-3">
        <div class="col-md-8">
            <input type="text" name="category_name" class="form-control"
                placeholder="Nhập tên danh mục..." required>
        </div>
        <div class="col-md-4">
            <button type="submit" name="add_category" class="btn btn-success-custom btn-custom w-100">
                <i class="fas fa-plus me-2"></i>Thêm danh mục
            </button>
        </div>
    </form>
</div>

<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM categories ORDER BY category_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categories as $row):
            ?>
                <tr>
                    <td><?php echo $row['category_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger-custom btn-sm btn-custom"
                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                <i class="fas fa-trash me-1"></i>Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <h2 class="mb-4">Brand Management</h2>

<div class="form-container">
    <h5 class="mb-3">Thêm thương hiệu mới</h5>
    <form method="POST" class="row g-3">
        <div class="col-md-8">
            <input type="text" name="brand_name" class="form-control" 
                   placeholder="Nhập tên thương hiệu..." required>
        </div>
        <div class="col-md-4">
            <button type="submit" name="add_brand" class="btn btn-success-custom btn-custom w-100">
                <i class="fas fa-plus me-2"></i>Thêm thương hiệu
            </button>
        </div>
    </form>
</div>

<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên thương hiệu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM brands ORDER BY brand_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($brands as $row):
            ?>
            <tr>
                <td><?php echo $row['brand_id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="brand_id" value="<?php echo $row['brand_id']; ?>">
                        <button type="submit" name="delete_brand" class="btn btn-danger-custom btn-sm btn-custom" 
                                onclick="return confirm('Bạn có chắc muốn xóa thương hiệu này?')">
                           <i class="bi bi-trash3-fill"></i>Xóa
                        </button>

                        <button type="submit" name="edit_brand" class="btn btn-danger-custom btn-sm btn-custom" 
                                onclick="return confirm('Bạn có chắc muốn sửa thương hiệu này?')">
                           <i class="bi bi-pencil-fill"></i>Sửa
                        </button>

                        
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

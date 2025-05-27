<h2 class="mb-4">Insert Products</h2>

<div class="form-container">
    <h5 class="mb-3">Thêm sản phẩm mới</h5>
    <form method="POST" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Số lượng</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">URL hình ảnh</label>
            <input type="text" name="image_url" class="form-control">
        </div>

        <!-- lấy trong categories -->
        <div class="col-md-6">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <option value="">Chọn danh mục</option>
                <?php
                $sql = "SELECT * FROM categories ORDER BY name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $cat):
                ?>
                <option value="<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
       <!-- lấy trong brands -->
        <div class="col-md-6">
            <label class="form-label">Thương hiệu</label>
            <select name="brand_id" class="form-select" required>
                <option value="">Chọn thương hiệu</option>
                <?php
                $sql = "SELECT * FROM brands ORDER BY name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($brands as $brand):
                ?>
                <option value="<?php echo $brand['brand_id']; ?>"><?php echo htmlspecialchars($brand['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả sản phẩm..."></textarea>
        </div>
        <div class="col-12">
            <button type="submit" name="add_product" class="btn btn-success-custom btn-custom">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
            </button>
        </div>
    </form>
</div>
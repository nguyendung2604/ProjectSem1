<h2 class="mb-4">User Management</h2>

<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Mật khẩu</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM users ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $row):
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo $row['password']; ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <span class="badge bg-<?php echo $row['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                        <?php echo ($row['role']); ?>
                    </span>
                </td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_user" class="btn btn-danger-custom btn-sm btn-custom" 
                                onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                            <i class="fas fa-trash me-1"></i>Xóa
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
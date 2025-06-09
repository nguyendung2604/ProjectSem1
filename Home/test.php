<?php
// Kết nối database
require 'db_connect.php';

try {
    // Truy vấn lấy danh sách sản phẩm, kết hợp với brands và product_images
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.name, p.description, p.price, p.quantity, b.name AS brand_name, pi.image_url
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        ORDER BY p.created_at DESC
    ");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Wireless World | MobileMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-pacifico {
            font-family: 'Pacifico', cursive;
        }
        .product-card {
            transition: all 0.3s ease;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
            background: #f8f9fa;
        }
        .price-original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9em;
        }
        .price-current {
            color: #e44d26;
            font-weight: 700;
            font-size: 1.25em;
        }
        .brand-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .stock-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .product-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #6c757d;
            font-size: 0.875rem;
            line-height: 1.4;
        }
        .btn-view-details {
            transition: all 0.3s ease;
        }
        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>
<body class="bg-light">
    

    <!-- Main Content -->
    <main class="pt-5 mt-4">
        <!-- Page Header -->
     

        <!-- Products Grid -->
        <section class="py-5">
            <div class="container">
                <?php if (empty($products)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-phone display-1 text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">No Products Available</h3>
                        <p class="text-muted">We're working hard to add new products. Please check back soon!</p>
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Go Back Home
                        </a>
                    </div>
                <?php else: ?>
              

                    <!-- Products Grid -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <div class="card product-card border-0 shadow-sm h-100">
                                    <div class="position-relative">
                                        <?php if ($product['image_url']): ?>
                                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                 class="card-img-top product-image">
                                        <?php else: ?>
                                            <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                                <i class="bi bi-phone text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Stock Badge -->
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <?php if ($product['quantity'] > 0): ?>
                                                <span class="badge bg-success stock-badge">
                                                    <i class="bi bi-check-circle me-1"></i>In Stock
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger stock-badge">
                                                    <i class="bi bi-x-circle me-1"></i>Out of Stock
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Brand Badge -->
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-primary bg-opacity-90 brand-badge">
                                                <?php echo htmlspecialchars($product['brand_name']); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-semibold mb-2">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </h5>
                                        
                                        <p class="product-description mb-3">
                                            <?php echo htmlspecialchars($product['description']); ?>
                                        </p>

                                        <div class="mt-auto">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div>
                                                    <div class="price-current">
                                                        $<?php echo number_format($product['price']); ?>
                                                    </div>
                                                    <!-- Optional: Add original price for discount effect -->
                                                    <!-- <div class="price-original">$<?php echo number_format($product['price'] * 1.2, 2); ?></div> -->
                                                </div>
                                                <?php if ($product['quantity'] > 0): ?>
                                                    <small class="text-success fw-medium">
                                                        <?php echo $product['quantity']; ?> available
                                                    </small>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-grid gap-2">
                                                <a href="product_details.php?id=<?php echo $product['product_id']; ?>" 
                                                   class="btn btn-primary btn-view-details">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                                
                                                <?php if ($product['quantity'] > 0): ?>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                                        <i class="bi bi-bell me-1"></i>Notify When Available
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                  
                <?php endif; ?>
            </div>
        </section>
    </main>

 </body>
</html>
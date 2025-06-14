<?php
// Kết nối database
require 'db_connect.php';

try {
    // Truy vấn lấy danh sách sản phẩm với chỉ 1 ảnh đầu tiên
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.name, p.description, p.price, p.quantity, 
               b.name AS brand_name, 
               (SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1) AS image_url
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
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
    <title>Wireless World</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
    
   
</head>
<body>
 <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand brand-font text-primary me-4" href="#">Wireless World</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="d-flex align-items-center order-lg-last">
                <!-- Search Bar -->
                <div class="position-relative me-3">
                    <input type="text" class="form-control pe-5 search-input" placeholder="Search phones...">
                    <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                        <i class="bi bi-search text-muted"></i>
                    </div>
                </div>

                <!-- Icons -->
                <button class="btn btn-link text-dark p-2 me-2 nav-icon" aria-label="Shopping Cart">
                    <i class="bi bi-bag"></i>
                </button>
                
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-link text-dark p-2 me-2 nav-icon" type="button" id="userDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="User Profile">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="login.php">Login</a></li>
                        <li><a class="dropdown-item" href="register.php">Register</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#brands">Brands</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link fw-medium" href="#catrgory">Catrgory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#deals">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <div class="container py-5">
            <div class="row align-items-center min-vh-50">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold text-dark mb-4">Find Your Perfect Smartphone</h1>
                    <p class="lead text-muted mb-4">Compare features, specs, and prices across all major brands to make the best choice for your needs.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="#compare" class="btn btn-primary btn-lg">Shop Now</a>
                        <a href="#deals" class="btn btn-outline-secondary btn-lg">View Deals</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="bg-white py-4 shadow-sm">
            <div class="container">
                <div class="row g-4">
                    <div class="col-6 col-md-3 text-center">
                        <p class="text-muted small mb-1">Phones Available</p>
                        <p class="h3 fw-bold text-dark mb-0">500+</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <p class="text-muted small mb-1">Brands</p>
                        <p class="h3 fw-bold text-dark mb-0">25+</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <p class="text-muted small mb-1">Daily Comparisons</p>
                        <p class="h3 fw-bold text-dark mb-0">2,500+</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <p class="text-muted small mb-1">Happy Users</p>
                        <p class="h3 fw-bold text-dark mb-0">1M+</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



<!-- Featured Products Section -->
<section>
    <div class="product-container">
        <?php if (empty($products)): ?>
            <p>No products available.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <img src="default-image.jpg" alt="No image available">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
                    <p class="price">$<?php echo number_format($product['price']); ?></p>

                      <!-- Icons -->
                <button class="btn btn-link text-dark p-2 me-2 nav-icon" aria-label="Shopping Cart">
                     <a href="product_details.php?id=<?php echo $product['product_id']; ?>"> <i class="bi bi-eye"></i> </a>
                </button>
                  <button class="btn btn-link text-dark p-2 me-2 nav-icon" aria-label="Shopping Cart">
                   <i class="bi bi-arrow-left-right"></i>
                </button>
                    <div class="button-group">
                        <button class="add-to-cart" onclick="addToCart(<?php echo $product['product_id']; ?>)">Add to Cart</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>



    



  

    <!-- Newsletter Section -->
    <section class="py-5 newsletter-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="h2 fw-bold mb-4">Stay Updated</h2>
                    <p class="text-muted mb-4">Subscribe to our newsletter to receive updates on the latest smartphone releases, exclusive deals, and tech news.</p>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control newsletter-input" placeholder="Your email address">
                                <button class="btn btn-primary newsletter-button" type="button">Subscribe</button>
                            </div>
                        </div>
                    </div>
                    
                    <p class="small text-muted">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="h2 fw-bold text-center mb-5">About Us</h2>
                    
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            <p class="text-muted mb-3">Wireless World is your ultimate destination for smartphone comparison and discovery. We help millions of users make informed decisions when purchasing a new mobile device.</p>
                            <p class="text-muted mb-3">Our mission is to simplify the phone buying process by providing comprehensive, unbiased comparisons and up-to-date information on the latest devices from all major manufacturers.</p>
                            <p class="text-muted mb-4">Founded in 2020, we've grown to become one of the most trusted resources for smartphone buyers worldwide, with over 1 million monthly active users.</p>
                            
                            <div class="d-flex gap-4">
                                <a href="#" class="text-primary text-decoration-none fw-medium">Learn more about us</a>
                                <a href="#contact" class="text-primary text-decoration-none fw-medium">Contact our team</a>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="h3 fw-bold text-primary mb-2">500+</div>
                                        <p class="text-muted mb-0">Phones in database</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="h3 fw-bold text-primary mb-2">25+</div>
                                        <p class="text-muted mb-0">Brands covered</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="h3 fw-bold text-primary mb-2">1M+</div>
                                        <p class="text-muted mb-0">Monthly users</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="h3 fw-bold text-primary mb-2">4.8/5</div>
                                        <p class="text-muted mb-0">User satisfaction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="h2 fw-bold text-center mb-5">Contact Us</h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm border-0">
                        <div class="row g-0">
                            <div class="col-lg-6 p-4 p-lg-5">
                                <h3 class="h4 fw-semibold mb-4">Get in Touch</h3>
                                <p class="text-muted mb-4">Have questions or feedback? We'd love to hear from you. Fill out the form and our team will get back to you shortly.</p>
                                
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-medium">Your Name</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-medium">Email Address</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="subject" class="form-label fw-medium">Subject</label>
                                        <input type="text" class="form-control" id="subject">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="message" class="form-label fw-medium">Message</label>
                                        <textarea class="form-control" id="message" rows="4"></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </form>
                            </div>
                            
                            <div class="col-lg-6 bg-light p-4 p-lg-5">
                                <h3 class="h4 fw-semibold mb-4">Contact Information</h3>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <div class="contact-icon me-3">
                                        <i class="bi-geo-alt"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-medium mb-1">Address</h4>
                                        <p class="text-muted mb-0">285 Doi Can, Lieu Giai Ward, Ba Dinh District, Hanoi</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <div class="contact-icon me-3">
                                        <i class="bi-envelope"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-medium mb-1">Email</h4>
                                        <p class="text-muted mb-0">wirelessworld@gmail.com</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <div class="contact-icon me-3">
                                        <i class="bi-telephone"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-medium mb-1">Phone</h4>
                                        <p class="text-muted mb-0">+84 123456789</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-4">
                                    <div class="contact-icon me-3">
                                        <i class="bi-clock"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-medium mb-1">Working Hours</h4>
                                        <p class="text-muted mb-0">Monday - Friday: 9AM - 6PM<br>Saturday: 10AM - 4PM</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="fw-medium mb-3">Follow Us</h4>
                                    <div class="d-flex gap-3">
                                        <a href="#" class="social-icon">
                                            <i class="bi-facebook"></i>
                                        </a>
                                        <a href="#" class="social-icon">
                                            <i class="bi-twitter-x"></i>
                                        </a>
                                        <a href="#" class="social-icon">
                                            <i class="bi-instagram"></i>
                                        </a>
                                        <a href="#" class="social-icon">
                                            <i class="bi-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Google Map -->
                                <div class="map-container mt-4">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.92312398634!2d105.81641017471458!3d21.035761787539037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab0d127a01e7%3A0xab069cd4eaa76ff2!2zMjg1IFAuIMSQ4buZaSBD4bqlbiwgTGnhu4V1IEdpYWcsIEJhIMSQw6xuaCwgSMOgIE7hu5lpIDEwMDAwMCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1747289103783!5m2!1sen!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ vị trí công ty" width="100%" height="300" style="border:0;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="brand-font text-white text-decoration-none h4 d-block mb-3">Wireless World</a>
                    <p class="text-muted mb-4">Your ultimate destination for smartphone comparison and discovery. Find the perfect phone that matches your needs and budget.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon">
                            <i class="bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi-twitter-x fs-5"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi-instagram fs-5"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi-youtube fs-5"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h3 class="h5 fw-semibold mb-3">Quick Links</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#brands" class="text-muted text-decoration-none">Browse Brands</a></li>
                        <li class="mb-2"><a href="#compare" class="text-muted text-decoration-none">Compare Phones</a></li>
                        <li class="mb-2"><a href="#deals" class="text-muted text-decoration-none">Deals & Offers</a></li>
                        <li class="mb-2"><a href="#about" class="text-muted text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#contact" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h3 class="h5 fw-semibold mb-3">Top Brands</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Samsung</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Apple</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Google</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Xiaomi</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Sony</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">View All Brands</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h3 class="h5 fw-semibold mb-3">Support</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Terms of Service</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Cookie Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Sitemap</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Accessibility</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-top border-secondary pt-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted small mb-3 mb-md-0">© 2025 MobileMaster. All rights reserved.</p>
                    </div>
                    
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <span class="text-muted small">Payment Methods:</span>
                            <div class="d-flex gap-2">
                                <i class="bi-credit-card-2-front fs-5"></i>
                                <i class="bi-paypal fs-5"></i>
                                <i class="bi-apple fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
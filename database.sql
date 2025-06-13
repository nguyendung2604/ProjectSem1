CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE brands (
    brand_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    category_id INT,
    brand_id INT,
    quantity INT NOT NULL,
    avatar_product VARCHAR(255) NOT NULL,
    screen_size VARCHAR(50),
    ram VARCHAR(50),
    storage VARCHAR(50),
    camera VARCHAR(100),
    battery VARCHAR(50),
    os VARCHAR(50),
    cpu VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id) ON DELETE CASCADE





);

CREATE TABLE product_images (
    product_image_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE carts (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE cart_items (
    cart_item_id INT PRIMARY KEY AUTO_INCREMENT,
    cart_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_price INT NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    status ENUM('pending', 'delivered') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);






-- Tạo dữ liệu mẫu cho Wireless World



-- 1. INSERT USERS
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2b$10$hashedpassword1', 'admin@wirelessworld.com', 'admin'),


-- 2. INSERT CATEGORIES
INSERT INTO categories (name) VALUES
('Smartphone'),
('Best Sellers'),
('Great Price Under $200'),
('Best Deals'),
('Flagship'),
('Mid-range'),
('Budget');

-- 3. INSERT BRANDS
INSERT INTO brands (name) VALUES
('Samsung'),
('Apple'),
('Xiaomi'),
('Huawei'),
('Nokia'),
('Motorola'),
('Sony'),
('LG'),
('OnePlus'),
('Realme');


-- Samsung Products
INSERT INTO products (name, description, price, category_id, brand_id, quantity, avatar_product, screen_size, ram, storage, camera, battery, os, cpu) VALUES
('Samsung Galaxy S25 Ultra', 'Flagship smartphone with 200MP camera and integrated S Pen', 1199.99, 1, 1, 50, '/image/galaxy-s25-1.png', '6.8 inch', '12GB', '256GB', '200MP + 12MP + 10MP + 10MP', '5000 mAh', 'Android 14', 'Snapdragon 8 Gen 3'),
('Samsung Galaxy S24', 'Compact flagship smartphone with powerful performance', 899.99, 1, 1, 40, '/image/galaxy-s24-1.png', '6.2 inch', '8GB', '256GB', '50MP + 12MP + 10MP', '4000 mAh', 'Android 14', 'Snapdragon 8 Gen 3'),
('Samsung Galaxy A56 5G', 'Mid-range smartphone with 50MP camera and long-lasting battery', 369.99, 6, 1, 100, '/image/galaxy-a56-1.avif', '6.4 inch', '8GB', '128GB', '50MP + 12MP + 5MP', '5000 mAh', 'Android 13', 'Exynos 1380'),
('Samsung Galaxy Z Fold6', 'Premium foldable phone with dual screen', 1799.99, 5, 1, 15, '/image/galaxy-z-fold6-1.png', '7.6 inch', '12GB', '256GB', '50MP + 12MP + 10MP', '4400 mAh', 'Android 13', 'Snapdragon 8 Gen 2');

-- Apple Products
INSERT INTO products (name, description, price, category_id, brand_id, quantity, avatar_product, screen_size, ram, storage, camera, battery, os, cpu) VALUES
('iPhone 15 Pro Max', 'Premium iPhone with A17 Pro chip and 48MP camera', 1299.99, 5, 2, 30, '/image/15-pro-max-den-1.webp', '6.7 inch', '8GB', '256GB', '48MP + 12MP + 12MP', '4441 mAh', 'iOS 17', 'Apple A17 Pro'),
('iPhone 15', 'iPhone with dual camera and Dynamic Island', 929.99, 1, 2, 45, '/image/iphone-15-den-1.webp', '6.1 inch', '6GB', '128GB', '48MP + 12MP', '3349 mAh', 'iOS 17', 'Apple A16 Bionic'),
('iPhone 14', 'iPhone with dual camera and powerful A15 Bionic chip', 799.99, 2, 2, 40, '/image/iphone-14-den-1.webp', '6.1 inch', '6GB', '128GB', '12MP + 12MP', '3279 mAh', 'iOS 16', 'Apple A15 Bionic'),
('iPhone 13', 'iPhone with improved dual camera system', 729.99, 6, 2, 35, '/image/iphone-13-den-1.webp', '6.1 inch', '4GB', '128GB', '12MP + 12MP', '3240 mAh', 'iOS 15', 'Apple A15 Bionic');

-- Xiaomi Products
INSERT INTO products (name, description, price, category_id, brand_id, quantity, avatar_product, screen_size, ram, storage, camera, battery, os, cpu) VALUES
('Xiaomi 15 5G', 'Professional camera smartphone with 1-inch sensor', 1019.99, 5, 3, 25, '/image/xiaomi-15-1.jpg', '6.73 inch', '16GB', '512GB', '50MP + 50MP + 50MP + 50MP', '5300 mAh', 'Android 14', 'Snapdragon 8 Gen 3'),
('Xiaomi 14T', 'Compact flagship with Leica camera', 729.99, 1, 3, 35, '/image/xiaomi-14t-den-1.jpg', '6.36 inch', '12GB', '256GB', '50MP + 50MP + 50MP', '4610 mAh', 'Android 14', 'Snapdragon 8 Gen 3'),
('Redmi 13x', 'Mid-range smartphone with 200MP camera and 67W fast charging', 289.99, 2, 3, 80, '/image/xiaomi-redmi-13x-1.jpg', '6.67 inch', '8GB', '256GB', '200MP + 8MP + 2MP', '5100 mAh', 'Android 13', 'Snapdragon 7s Gen 2');



-- 5. INSERT PRODUCT IMAGES (with /image/ prefix)
INSERT INTO product_images (product_id, image_url) VALUES
-- Galaxy S25 Ultra images
(1, '/image/galaxy-s25-1.png'),
(1, '/image/galaxy-s25-2.png'),
(1, '/image/galaxy-s25-3.png'),
(1, '/image/galaxy-s25-4.png'),

-- Galaxy S24 images
(2, '/image/galaxy-s24-1.png'),
(2, '/image/galaxy-s24-2.png'),
(2, '/image/galaxy-s24-3.png'),
(2, '/image/galaxy-s24-4.png'),

-- Galaxy A56 5G images
(3, '/image/galaxy-a56-1.avif'),
(3, '/image/galaxy-a56-2.avif'),
(3, '/image/galaxy-a56-3.avif'),
(3, '/image/galaxy-a56-4.avif'),

-- Galaxy Z Fold6 images
(4, '/image/galaxy-z-fold6-1.png'),
(4, '/image/galaxy-z-fold6-2.png'),
(4, '/image/galaxy-z-fold6-3.png'),
(4, '/image/galaxy-z-fold6-4.png'),

-- iPhone 15 Pro Max images
(5, '/image/15-pro-max-den-1.webp'),
(5, '/image/15-pro-max-den-3.webp'),
(5, '/image/15-pro-max-den-4.webp'),
(5, '/image/15-pro-max-den-5.webp'),

-- iPhone 15 images
(6, '/image/iphone-15-den-1.webp'),
(6, '/image/iphone-15-den-2.webp'),
(6, '/image/iphone-15-den-3.webp'),
(6, '/image/iphone-15-den-6.webp'),

-- iPhone 14 images
(7, '/image/iphone-14-den-1.webp'),
(7, '/image/iphone-14-den-2.webp'),
(7, '/image/iphone-14-den-3.webp'),
(7, '/image/iphone-14-den-4.webp'),

-- iPhone 13 images
(8, '/image/iphone-13-den-1.webp'),
(8, '/image/iphone-13-den-2.webp'),
(8, '/image/iphone-13-den-3.webp'),
(8, '/image/iphone-13-den-4.webp'),

-- Xiaomi 15 5G images
(9, '/image/xiaomi-15-1.jpg'),
(9, '/image/xiaomi-15-2.jpg'),
(9, '/image/xiaomi-15-3.jpg'),
(9, '/image/xiaomi-15-4.jpg'),

-- Xiaomi 14T images
(10, '/image/xiaomi-14t-den-1.jpg'),
(10, '/image/xiaomi-14t-den-2.jpg'),
(10, '/image/xiaomi-14t-den-3.jpg'),
(10, '/image/xiaomi-14t-den-4.jpg'),

-- Redmi 13x images
(11, '/image/xiaomi-redmi-13x-1.jpg'),
(11, '/image/xiaomi-redmi-13x-2.jpg'),
(11, '/image/xiaomi-redmi-13x-3.jpg'),
(11, '/image/xiaomi-redmi-13x-4.jpg');



--
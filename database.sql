-- Marine Diesel Engines Website Database Schema
-- US Engines Production - Marine Division

USE marine_engines_db;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin','editor','viewer') DEFAULT 'admin',
    is_active TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Categories (Manufacturers)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    parent_id INT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Products (Engines)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) UNIQUE,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(280) NOT NULL UNIQUE,
    short_description TEXT,
    description TEXT,
    category_id INT,
    product_type ENUM('marine_propulsion','marine_auxiliary','marine_generator','industrial') DEFAULT 'marine_propulsion',
    brand VARCHAR(100),
    model VARCHAR(100),
    engine_series VARCHAR(100),
    engine_size VARCHAR(50),
    displacement VARCHAR(50),
    cylinders VARCHAR(20),
    configuration VARCHAR(50),
    fuel_type ENUM('diesel') DEFAULT 'diesel',
    aspiration VARCHAR(50),
    horsepower_min INT,
    horsepower_max INT,
    horsepower VARCHAR(50),
    torque VARCHAR(50),
    rpm_range VARCHAR(50),
    weight_lbs INT,
    dimensions VARCHAR(100),
    condition_type ENUM('remanufactured','rebuilt','new','used') DEFAULT 'remanufactured',
    application VARCHAR(255),
    emissions_tier VARCHAR(50),
    cooling_system VARCHAR(50),
    fuel_system VARCHAR(100),
    price DECIMAL(10,2),
    sale_price DECIMAL(10,2),
    call_for_price TINYINT(1) DEFAULT 1,
    core_charge DECIMAL(10,2),
    warranty VARCHAR(100) DEFAULT '1-Year Unlimited Hours',
    in_stock TINYINT(1) DEFAULT 1,
    featured TINYINT(1) DEFAULT 0,
    image VARCHAR(255),
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    views INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Product images (multiple per product)
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    display_order INT DEFAULT 0,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Quote requests
CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    company VARCHAR(100),
    vessel_name VARCHAR(100),
    vessel_type VARCHAR(50),
    vin VARCHAR(50),
    engine_model VARCHAR(100),
    engine_type VARCHAR(50),
    product_id INT,
    message TEXT,
    status ENUM('new','contacted','quoted','converted','closed') DEFAULT 'new',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Blog posts
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(280) NOT NULL UNIQUE,
    content LONGTEXT,
    excerpt TEXT,
    featured_image VARCHAR(255),
    author_id INT,
    status ENUM('draft','published','archived') DEFAULT 'draft',
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    views INT DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Promotions
CREATE TABLE IF NOT EXISTS promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    promo_type ENUM('banner','popup','sale','announcement') DEFAULT 'banner',
    image VARCHAR(255),
    link_url VARCHAR(500),
    link_text VARCHAR(100),
    discount_percent INT,
    start_date DATE,
    end_date DATE,
    display_location ENUM('homepage','category','product','all') DEFAULT 'homepage',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Site settings
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('text','textarea','image','boolean','number') DEFAULT 'text',
    setting_group VARCHAR(50) DEFAULT 'general',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact submissions
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('new','read','replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- SEO pages (custom landing pages)
CREATE TABLE IF NOT EXISTS seo_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(280) NOT NULL UNIQUE,
    content LONGTEXT,
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, email, password, full_name, role) VALUES
('admin', 'admin@usengineproduction.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert default site settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group) VALUES
('site_name', 'US Engines Production - Marine Division', 'text', 'general'),
('site_tagline', 'Premium Remanufactured Marine Diesel Engines', 'text', 'general'),
('site_email', 'info@usengineproduction.com', 'text', 'general'),
('site_phone', '(888) 555-0199', 'text', 'general'),
('site_address', 'United States', 'text', 'general'),
('logo', '', 'image', 'general'),
('favicon', '', 'image', 'general'),
('homepage_hero_title', 'Premium Remanufactured Marine Diesel Engines', 'text', 'homepage'),
('homepage_hero_subtitle', 'Complete line of remanufactured marine diesel engines from all major manufacturers. Built to OEM specifications with industry-leading warranties.', 'textarea', 'homepage'),
('footer_text', '© 2026 US Engines Production. All Rights Reserved.', 'text', 'general'),
('google_analytics', '', 'text', 'seo'),
('meta_title', 'US Engines Production | Remanufactured Marine Diesel Engines', 'text', 'seo'),
('meta_description', 'Leading supplier of remanufactured marine diesel engines. Cummins, Caterpillar, Detroit Diesel, Volvo Penta, Yanmar, MAN, MTU and more. Call for quote.', 'textarea', 'seo');

-- Create indexes for performance
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_brand ON products(brand);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_products_featured ON products(featured);
CREATE INDEX idx_products_type ON products(product_type);
CREATE INDEX idx_quotes_status ON quotes(status);
CREATE INDEX idx_blog_status ON blog_posts(status);
CREATE INDEX idx_categories_slug ON categories(slug);
CREATE INDEX idx_products_slug ON products(slug);

-- Create the database (run this separately if needed)
-- CREATE DATABASE seaofblack_db;
-- Then connect to the database before running the tables below

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phonenumber VARCHAR(20),
    country VARCHAR(100),
    city VARCHAR(100),
    postal VARCHAR(20),
    address TEXT,
    reset_token VARCHAR(255) NULL,
    reset_token_expiry TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes for performance
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_reset_token ON users(reset_token);

-- Create orders table (for future use)
CREATE TABLE IF NOT EXISTS orders (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    status VARCHAR(50) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create index for orders
CREATE INDEX IF NOT EXISTS idx_orders_user_id ON orders(user_id);

-- Create products table (for future use)
CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255) DEFAULT './images/shop/default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample beer products matching the beers page
INSERT INTO products (name, description, price, stock, image) VALUES
('Your Girlfriend''s Girlfriend', 'Inspired by Type O Negative''s My Girlfriend''s Girlfriend, this beer blends bright citrus with bitter earth notes for a compelling American IPA experience.', 4.50, 20, './images/shop/yourgfsgf.png'),
('Lick It Up', 'Fun and fresh, inspired by Kiss. This American Pale Ale balances juicy hops with a mild, drinkable finish.', 5.00, 18, './images/shop/lickitup.png'),
('Space Lord', 'A crisp India Pale Lager with tropical hop notes and a smooth finish. Perfect for summer drinking.', 5.00, 15, './images/shop/spacelord.png'),
('Lady Lust', 'A decadent Milkshake IPA with orange and tangerine aroma, creamy sweetness, and a surprising bitter edge.', 5.50, 12, './images/shop/ladylust.png'),
('Wrong Side Of Heaven', 'A hazy New England IPA with fruity aromas, soft body, and a gentle bitterness that keeps you reaching for another sip.', 4.50, 10, './images/shop/wrongsideofheaven.png');

-- Create rate limiting table for security
CREATE TABLE IF NOT EXISTS login_attempts (
    id SERIAL PRIMARY KEY,
    ip_address INET NOT NULL,
    email VARCHAR(255),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    successful BOOLEAN DEFAULT FALSE
);

-- Create index for rate limiting performance
CREATE INDEX IF NOT EXISTS idx_login_attempts_ip_time ON login_attempts(ip_address, attempt_time);
CREATE INDEX IF NOT EXISTS idx_login_attempts_email_time ON login_attempts(email, attempt_time);

--Create review ids table (for future use)
CREATE TABLE IF NOT EXISTS reviews_guests (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    comment TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    approved BOOLEAN DEFAULT FALSE,
    author_image VARCHAR(255) DEFAULT './images/review/default_profile.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create contact_messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (firstname, lastname, email, password, phonenumber, country, city, postal, address) 
VALUES ('Admin', 'User', 'adminlogs@example.com', '$2y$12$EZ8m7V9iKRJcAl9YC2hbeOwIdv8ZmUpz9Iy7Kc0wMlFBEgMRPv5RK', NULL, NULL, NULL, NULL, NULL);

-- Insert sample approved reviews
INSERT INTO reviews_guests (name, comment, rating, approved, author_image) 
VALUES 
('John Doe', 'You should really check out this brewery! It''s amazing! Maybe only the location is a bit distant from the actual city. But then again, their beers make the trip worth it, and the forest really gives it a cool and cozy vibe.', 4, true, './images/review/default_profile.png'),
('George Georgiew', 'A really good place that you SHOULD check out! It''s worth it!', 5, true, './images/review/male_profile.png'),
('Aaron Cosmos', 'I tried Lick It Up and Space Lord. Best. Beers. Ever!', 5, true, './images/review/male_profile_2.png');
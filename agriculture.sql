
-- users table

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    user_type ENUM('user', 'admin') DEFAULT 'user',
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- inserting admin into the database

INSERT INTO users (name, email, user_type, password)
VALUES ('Daniel Kitonga', 'kitongadaniel@gmail.com', 'admin', '12345678');


-- livestock table
CREATE TABLE livestock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_type VARCHAR(50) NOT NULL,
    breed VARCHAR(50),
    quantity INT NOT NULL,
    birth_date DATE,
    status ENUM('Healthy', 'Sick', 'Sold') DEFAULT 'Healthy'
);


-- crops table

CREATE TABLE crops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_name VARCHAR(100) NOT NULL,
    planted_date DATE,
    expected_yield DECIMAL(10,2),
    actual_yield DECIMAL(10,2),
    status ENUM('Planted', 'Growing', 'Harvested') DEFAULT 'Planted'
);

-- farmers table
CREATE TABLE farmers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    farmer_name VARCHAR(255) NOT NULL,
    farmer_email VARCHAR(255) UNIQUE NOT NULL,
    farm_location VARCHAR(255) NOT NULL,
    farmer_number VARCHAR(20) NOT NULL,
    farm_type ENUM('Crop', 'Livestock', 'Mixed') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- revenue table

CREATE TABLE revenue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255)
);

-- workers table
CREATE TABLE workers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- farm table

CREATE TABLE farms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farm_name VARCHAR(255) NOT NULL,
    farm_location VARCHAR(255) NOT NULL,
    farm_size DECIMAL(10,2) NOT NULL, -- Stores size in acres or hectares
    owner_id INT NOT NULL, -- Foreign key linking to farmers table
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES farmers(id) ON DELETE CASCADE
);

-- task table

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    assigned_worker INT,
    deadline DATE NOT NULL,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);





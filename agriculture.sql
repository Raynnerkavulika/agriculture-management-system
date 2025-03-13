


-- livestock table
CREATE TABLE livestock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farm_id INT NOT NULL,
    animal_type VARCHAR(50) NOT NULL,
    breed VARCHAR(50),
    quantity INT NOT NULL,
    birth_date DATE,
    status ENUM('Healthy', 'Sick', 'Sold') DEFAULT 'Healthy',
    FOREIGN KEY (farm_id) REFERENCES farms(id) ON DELETE CASCADE
);


-- crops table

CREATE TABLE crops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farm_id INT NOT NULL,
    crop_name VARCHAR(100) NOT NULL,
    planted_date DATE,
    expected_yield DECIMAL(10,2),
    actual_yield DECIMAL(10,2),
    status ENUM('Planted', 'Growing', 'Harvested') DEFAULT 'Planted',
    FOREIGN KEY (farm_id) REFERENCES farms(id) ON DELETE CASCADE
);


-- revenue table

CREATE TABLE revenue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255)
);

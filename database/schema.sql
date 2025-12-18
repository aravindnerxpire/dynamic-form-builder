-- Database: dynamic_form_builder

-- 1. Forms Table
CREATE TABLE IF NOT EXISTS forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Form Fields Table
CREATE TABLE IF NOT EXISTS form_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    label VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    required TINYINT(1) DEFAULT 0,
    placeholder VARCHAR(255),
    sort_order INT DEFAULT 1,
    FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE
);

-- 3. Field Options Table (for dropdown, radio, checkbox)
CREATE TABLE IF NOT EXISTS field_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_id INT NOT NULL,
    option_text VARCHAR(255) NOT NULL,
    FOREIGN KEY (field_id) REFERENCES form_fields(id) ON DELETE CASCADE
);

-- 4. Form Responses Table (each submission)
CREATE TABLE IF NOT EXISTS form_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    user_id INT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE
);

-- 5. Form Response Values Table (field-wise submission)
CREATE TABLE IF NOT EXISTS form_response_values (
    id INT AUTO_INCREMENT PRIMARY KEY,
    response_id INT NOT NULL,
    field_id INT NOT NULL,
    value TEXT,
    FOREIGN KEY (response_id) REFERENCES form_responses(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id) REFERENCES form_fields(id) ON DELETE CASCADE
);

-- Create the database
CREATE DATABASE IF NOT EXISTS your_database_name;

-- Use the database
USE your_database_name;

-- Create the attendance table
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_number VARCHAR(20) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    sex VARCHAR(10) NOT NULL,
    am_in TIME,
    am_out TIME,
    pm_in TIME,
    pm_out TIME,
    am_late TIME,
    am_undertime TIME,
    pm_late TIME,
    pm_undertime TIME
);

-- Insert sample data if needed
INSERT INTO attendance (id_number, first_name, middle_name, last_name, phone_number, sex)
VALUES
    ('123456', 'John', 'Doe', 'Smith', '555-1234', 'Male'),
    ('789012', 'Jane', 'Doe', 'Johnson', '555-5678', 'Female');

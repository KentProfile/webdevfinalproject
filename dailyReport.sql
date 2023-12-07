CREATE DATABASE IF NOT EXISTS attendance_db;

USE attendance_db;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    am_in DATETIME,
    am_out DATETIME,
    pm_in DATETIME,
    pm_out DATETIME,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

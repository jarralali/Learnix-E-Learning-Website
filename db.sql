-- Create a database (replace 'your_database_name' with your preferred name)
CREATE DATABASE db.sql;

-- Use the database
USE db.sql;

-- Create a table for users (replace 'users' with your preferred table name)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

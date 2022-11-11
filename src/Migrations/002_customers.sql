DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    city VARCHAR(255),
    postcode VARCHAR(255),
    street VARCHAR(255),
    country_id INT,
    phone VARCHAR(255),
    email VARCHAR(255),
    date_of_birth DATE,
    FOREIGN KEY (country_id) REFERENCES countries(id)
);

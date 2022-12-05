CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    city VARCHAR(100),
    postcode VARCHAR(20),
    street VARCHAR(100),
    country_id INT,
    phone VARCHAR(50),
    email VARCHAR(100),
    date_of_birth DATE,

    is_deleted BOOLEAN DEFAULT false,

    FOREIGN KEY (country_id)
        REFERENCES countries(id)
        ON DELETE CASCADE
);

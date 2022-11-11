DROP TABLE IF EXISTS additional_costs;

CREATE TABLE additional_costs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    price DOUBLE(10, 2)
);

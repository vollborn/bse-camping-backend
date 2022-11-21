CREATE TABLE additional_costs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    additional_cost_type_id INT,

    display_name VARCHAR(255),
    price DOUBLE(10, 2),

    FOREIGN KEY (additional_cost_type_id)
        REFERENCES additional_cost_types(id)
        ON DELETE CASCADE
);

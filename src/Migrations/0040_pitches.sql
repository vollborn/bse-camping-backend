CREATE TABLE pitches (
    id INT PRIMARY KEY AUTO_INCREMENT,
    field_number VARCHAR(255),
    width DOUBLE(10, 2),
    height DOUBLE(10, 2),
    price_per_day DOUBLE(10, 2),
    coordinate_x INTEGER,
    coordinate_y INTEGER
);

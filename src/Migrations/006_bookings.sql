DROP TABLE IF EXISTS bookings;

CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    pitch_id INT,
    start_at DATE,
    end_at DATE,
    has_pets BOOLEAN,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (pitch_id) REFERENCES pitches(id)
);

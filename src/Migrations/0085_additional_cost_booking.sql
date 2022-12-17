CREATE TABLE additional_cost_booking
(
    booking_id INT NOT NULL,
    additional_cost_id INT NOT NULL,

    amount INT NOT NULL,

    PRIMARY KEY (booking_id, additional_cost_id),

    FOREIGN KEY (additional_cost_id)
        REFERENCES additional_costs (id)
        ON DELETE CASCADE,

    FOREIGN KEY (booking_id)
        REFERENCES bookings (id)
        ON DELETE CASCADE
);

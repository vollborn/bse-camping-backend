CREATE TABLE booking_person (
    booking_id INT NOT NULL,
    person_id INT NOT NULL,

    PRIMARY KEY (booking_id, person_id),

    FOREIGN KEY (person_id)
        REFERENCES persons(id)
        ON DELETE CASCADE,

    FOREIGN KEY (booking_id)
        REFERENCES bookings(id)
        ON DELETE CASCADE
);

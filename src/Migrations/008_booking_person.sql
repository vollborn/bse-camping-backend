DROP TABLE IF EXISTS booking_person;

CREATE TABLE booking_person (
    booking_id INT NOT NULL,
    person_id INT NOT NULL,

    PRIMARY KEY (booking_id, person_id),

    FOREIGN KEY (person_id) REFERENCES persons(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

INSERT INTO countries (name) values ("Deutschland"), ("Kinder Country"), ("Schland");

INSERT INTO customers (first_name, last_name, city, postcode, street, country_id, phone, email, date_of_birth) values 
("Lena", "Wau", "Hamburg", "22566", "Hans-Baum-Strasse 6", 1, "0407203481", "lena@mail.de", "2015-02-03"),
("Yo", "Oli", "Pinneberg", "23944", "Gans-Baum-Strasse 10", 1, "0402354481", "oli@mail.de", "2000-10-04"),
("Hans", "Wau", "Hamburg", "22566", "Walter-Baum-Strasse 1", 1, "04107203481", "hans@mail.de", "1999-12-06"),
("Walter", "Wau", "Dings", "23654", "Baum-Baum-Strasse 6", 1, "666666", "lena@mail.de", "2015-02-03");

INSERT INTO pitches (field_number, width, height) values 
("0.1", 10.10, 5.0),
("0.2", 5.10, 5.0),
("0.3", 6.10, 5.0),
("1.1", 7.10, 5.0),
("1.2", 10.10, 5.0),
("1.3", 10.10, 5.0),
("2.1", 5.10, 5.0),
("2.2", 10.10, 5.0),
("2.3", 8.10, 5.0);

INSERT INTO bookings (customer_id, pitch_id, start_at,  end_at, has_pets) value 
(1, 1, "2022-03-03", "2022-03-20", false),
(2, 3, "2022-03-03", "2022-03-19", true),
(3, 2, "2022-03-20", "2022-04-20", false),
(1, 1, "2022-04-03", "2022-04-20", true);

INSERT INTO persons (first_name, last_name, date_of_birth) values 
("Mama", "Wau", "1988-12-26"),
("Jannik", "Yannik", "2000-12-26"),
("Peter", "Meter", "1988-12-26"),
("Wulf", "Wau", "2015-02-16");

INSERT INTO booking_person (booking_id, person_id) values 
(1,1), 
(2,2), 
(3,3), 
(1,4);

INSERT INTO additional_costs (display_name, price) values
("Kinderpauschale", -10.00),
("Strompauschale", 100.00),
("Tierpauschale", 10.00);

INSERT INTO additional_cost_pitch (pitch_id, additional_cost_id) values 
(1,1),
(1,2),
(2,3),
(3,2),
(4,3);
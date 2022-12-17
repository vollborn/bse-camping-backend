INSERT INTO countries (name) VALUES ("Deutschland"), ("Kinder Country");

INSERT INTO customers (first_name, last_name, city, postcode, street, country_id, phone, email, date_of_birth) VALUES 
("Lena", "Wau", "Hamburg", "22566", "Hans-Baum-Strasse 6", 1, "0407203481", "lena@mail.de", "2015-02-03"),
("Yo", "Oli", "Pinneberg", "23944", "Gans-Baum-Strasse 10", 1, "0402354481", "oli@mail.de", "2000-10-04"),
("Hans", "Wau", "Hamburg", "22566", "Walter-Baum-Strasse 1", 1, "04107203481", "hans@mail.de", "1999-12-06"),
("Walter", "Wau", "Dings", "23654", "Baum-Baum-Strasse 6", 1, "666666", "lena@mail.de", "2015-02-03");

INSERT INTO pitches (field_number, width, height, price_per_day) VALUES
("0.1", 10.10, 5.0, 1.0),
("0.2", 5.10, 5.0, 2.0),
("0.3", 6.10, 5.0, 3.0),
("1.1", 7.10, 5.0, 4.0),
("1.2", 10.10, 5.0, 5.0),
("1.3", 10.10, 5.0, 6.0),
("2.1", 5.10, 5.0, 7.0),
("2.2", 10.10, 5.0, 8.0),
("2.3", 8.10, 5.0, 9.0);

INSERT INTO bookings (customer_id, pitch_id, start_at,  end_at, pet_count) value
(1, 1, "2022-03-03", "2022-03-20", 10),
(2, 3, "2022-03-03", "2022-03-19", 1),
(3, 2, "2022-03-20", "2022-04-20", 0),
(1, 1, "2022-04-03", "2022-04-20", 0);

INSERT INTO persons (first_name, last_name, date_of_birth) VALUES 
("Mama", "Wau", "1988-12-26"),
("Jannik", "Yannik", "2000-12-26"),
("Peter", "Meter", "1988-12-26"),
("Wulf", "Wau", "2015-02-16");

INSERT INTO booking_person (booking_id, person_id) VALUES 
(1,1), 
(2,2), 
(3,3), 
(1,4);

INSERT INTO additional_cost_types (id, display_name) VALUES
(1, "Einmaling"),
(2, "Einmaling pro Person"),
(3, "Einmaling pro Erwachsener"),
(4, "Einmaling pro Kind"),
(5, "Einmaling pro Haustier"),
(6, "Täglich"),
(7, "Täglich pro Person"),
(8, "Täglich pro Erwachsener"),
(9, "Täglich pro Kind"),
(10, "Täglich pro Haustier");

INSERT INTO additional_costs (additional_cost_type_id, display_name, price) VALUES
(1, "Strompauschale", 10.00),
(2, "Personenpauschale", 10.00),
(3, "Erwachsenenpauschale", 10.00),
(4, "Kinderpauschale", 10.00),
(5, "Tierpauschale", 10.00),
(6, "Stellplatzpauschale", 10.00),
(7, "Pool-Pauschale", 10.00),
(8, "Saunapauschale", 10.00),
(9, "Trampolinpauschale", 10.00),
(10, "Futterpauschale", 10.00);

INSERT INTO users (id, name, password, api_token) VALUES
(1, "admin", "$2y$10$MSbKfp/0uv13DGDhAjgeXOErqSBtrFBBd.Vbh0zbPYoO9QJUPcnLC", "test");

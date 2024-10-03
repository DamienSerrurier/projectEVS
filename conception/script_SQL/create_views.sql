--Vue permettant d'afficher toutes les civilités
CREATE OR REPLACE VIEW displayAllCivility
AS
SELECT civility.id, civility.name
FROM civility;

--Vue permettant d'afficher toutes les catégories d'activités
CREATE OR REPLACE VIEW displayAllCategory
AS
SELECT category.id, category.name
FROM category;

--Vue permettant d'afficher tous les utilisateurs
CREATE OR REPLACE VIEW displayAllUsers
AS
SELECT person.id, lastname, firstname, phone, role.name, id_avatar, id_address
FROM person
LEFT JOIN connection ON person.id_connection = connection.id
LEFT JOIN role ON person.id_role = role.id;

--Vue permettant d'afficher tous les administrateurs
CREATE OR REPLACE VIEW displayAllAdministrators
AS
SELECT _user, picture, street_number, street_name, street_complement,
code, city.name AS cityName
FROM displayAllUsers AS _user
LEFT JOIN avatar ON _user.id_avatar = avatar.id
LEFT JOIN address ON _user.id_address = address.id
JOIN address_complement ON address.id_address_complement = address_complement.id
JOIN zip_code ON address.code_zip_code = zip_code.code
JOIN city ON address.id_city = city.id
WHERE _user.name = 'Admin';

--Vue permettant d'afficher toutes les activités
CREATE OR REPLACE VIEW displayAllActivities
AS
SELECT activity.id, title, additional_information, date_start,
date_end, hour_start, hour_end, description,
picture, name
FROM activity
JOIN category ON activity.id_category = category.id;

--Vue permettant d'afficher toutes les structures
CREATE OR REPLACE VIEW displayAllStructures
AS
SELECT structure.name AS structureName, logo, phone, wording, street_number,
street_name, street_complement, code, city.name AS cityName
FROM structure
JOIN type_structure ON structure.id_type_structure = type_structure.id
JOIN address ON structure.id_address = address.id
JOIN address_complement ON address.id_address_complement = address_complement.id
JOIN zip_code ON address.code_zip_code = zip_code.code
JOIN city ON address.id_city = city.id;

--Vue permettant d'afficher toutes les écoles
CREATE OR REPLACE VIEW displayAllStructureSchools
AS
SELECT structure.id, structure.name AS structureName, logo, phone, wording, 
street_number, street_name, street_complement, code, city.name AS cityName
FROM structure
JOIN type_structure ON structure.id_type_structure = type_structure.id
JOIN address ON structure.id_address = address.id
JOIN address_complement ON address.id_address_complement = address_complement.id
JOIN zip_code ON address.code_zip_code = zip_code.code
JOIN city ON address.id_city = city.id
WHERE type_structure.wording = 'Ecole';

--Vue permettant d'afficher tous les documents avec toutes les écoles
CREATE OR REPLACE VIEW displayAllDocumentsWithSchools
AS
SELECT document.name, link, _user, upload_date, documentSchool
FROM document
JOIN displayAllStructureSchools AS documentSchool ON document.id_structure = documentSchool.id
JOIN upload ON document.id = upload.id_document
JOIN displayAllUsers AS _user ON upload.id_teacher = _user.id;

--Vue permettant d'afficher toutes les réservations
CREATE OR REPLACE VIEW displayAllReservations
AS
SELECT activity, _user, booking_date,
status, number_of_reservation
FROM reservation
JOIN displayAllUsers AS _user ON reservation.id_person = _user.id
JOIN displayAllActivities AS activity ON reservation.id_activity = activity.id;
--Création de la base de données
-- CREATE DATABASE projectEVS;

--Créations de tables par niveaux
--Niveau 0 - Tables sans clés étrangères
CREATE TABLE IF NOT EXISTS connection (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(70) NOT NULL
);

CREATE TABLE IF NOT EXISTS avatar (
    id SERIAL PRIMARY KEY,
    picture VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS role (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS civility (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS type_structure (
    id SERIAL PRIMARY KEY,
    wording VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS member_data (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255),
    profession VARCHAR(50),
    family_situation VARCHAR(50),
    caf_number CHAR(10) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS _date (
    yyyy_mm_dd DATE PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS category (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS address_complement (
    id SERIAL PRIMARY KEY,
    street_complement VARCHAR(50) 
);

CREATE TABLE IF NOT EXISTS zip_code (
    code VARCHAR(10) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS city (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

--Niveau 1 - Tables avec clés étrangères
CREATE TABLE If NOT EXISTS address (
    id SERIAL PRIMARY KEY,
    street_number VARCHAR(10),
    street_name VARCHAR(100) NOT NULL,
    id_address_complement INTEGER,
    code_zip_code VARCHAR(10) NOT NULL,
    id_city INTEGER NOT NULL,
    FOREIGN KEY(id_address_complement) REFERENCES address_complement(id),
    FOREIGN KEY(code_zip_code) REFERENCES zip_code(code),
    FOREIGN KEY(id_city) REFERENCES city(id)
);

CREATE TABLE IF NOT EXISTS person (
    id SERIAL PRIMARY KEY,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    id_civility INTEGER,
    id_avatar INTEGER,
    id_connection INTEGER,
    id_address INTEGER,
    id_role INTEGER DEFAULT 2,
    FOREIGN KEY(id_civility) REFERENCES civility(id),
    FOREIGN KEY(id_avatar) REFERENCES avatar(id),
    FOREIGN KEY(id_connection) REFERENCES connection(id),
    FOREIGN KEY(id_address) REFERENCES address(id),
    FOREIGN KEY(id_role) REFERENCES role(id)
);

CREATE TABLE IF NOT EXISTS structure (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255),
    phone VARCHAR(20) NOT NULL UNIQUE,
    id_type_structure INTEGER NOT NULL,
    id_address INTEGER NOT NULL,
    FOREIGN KEY(id_type_structure) REFERENCES type_structure(id),
    FOREIGN KEY(id_address) REFERENCES address(id)
);

CREATE TABLE IF NOT EXISTS document (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    link VARCHAR(255) NOT NULL,
    id_structure INTEGER NOT NULL,
    FOREIGN KEY(id_structure) REFERENCES structure(id)
);

CREATE TABLE IF NOT EXISTS activity (
    id SERIAL PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    additional_information VARCHAR(255),
    date_start DATE,
    date_end DATE,
    hour_start TIME,
    hour_end TIME,
    description TEXT,
    picture VARCHAR(255),
    id_category INTEGER NOT NULL,
    FOREIGN KEY(id_category) REFERENCES category(id)
);

CREATE TABLE IF NOT EXISTS _member (
    id SERIAL PRIMARY KEY,
    birthdate DATE NOT NULL,
    place_of_birth VARCHAR(50) NOT NULL,
    id_person INTEGER NOT NULL,
    id_pair INTEGER,
    id_member_data INTEGER,
    registration_date DATE NOT NULL DEFAULT CURRENT_DATE,
    UNIQUE(id_person, id_pair),
    FOREIGN KEY(id_person) REFERENCES person(id),
    FOREIGN KEY(id_pair) REFERENCES _member(id),
    FOREIGN KEY(id_member_data) REFERENCES member_data(id),
    FOREIGN KEY(registration_date) REFERENCES _date(yyyy_mm_dd)
);

CREATE TABLE IF NOT EXISTS upload (
    id_teacher INTEGER,
    id_document INTEGER,
    upload_date DATE NOT NULL DEFAULT CURRENT_DATE,
    PRIMARY KEY(id_teacher, id_document, upload_date),
    FOREIGN KEY(id_teacher) REFERENCES person(id),
    FOREIGN KEY(id_document) REFERENCES document(id),
    FOREIGN KEY(upload_date) REFERENCES _date(yyyy_mm_dd)
);

CREATE TABLE IF NOT EXISTS reservation (
    id_activity INTEGER,
    id_person INTEGER,
    booking_date DATE NOT NULL DEFAULT CURRENT_DATE,
    status BOOLEAN NOT NULL,
    number_of_reservation SMALLINT NOT NULL,
    PRIMARY KEY(id_activity, id_person, booking_date),
    FOREIGN KEY(id_activity) REFERENCES activity(id),
    FOREIGN KEY(id_person) REFERENCES person(id),
    FOREIGN KEY(booking_date) REFERENCES _date(yyyy_mm_dd)
);

CREATE TABLE IF NOT EXISTS supervisor (
    id SERIAL PRIMARY KEY,
    school VARCHAR(100) NOT NULL,
    id_structure INTEGER,
    id_member_not_responsible INTEGER NOT NULL,
    id_member_is_responsible INTEGER NOT NULL,
    FOREIGN KEY(id_structure) REFERENCES structure(id),
    FOREIGN KEY(id_member_not_responsible) REFERENCES _member(id),
    FOREIGN KEY(id_member_is_responsible) REFERENCES _member(id)
);
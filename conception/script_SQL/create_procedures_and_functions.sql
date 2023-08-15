--Insertion des civilité des membres
INSERT INTO civility (name)
VALUES ('Madame'),
       ('Monsieur');


--Procédure permettant de créer un role
CREATE OR REPLACE PROCEDURE insertRole(roleName VARCHAR(50))
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO role (name)
    VALUES (roleName);
END;
$$;

--Appel de la procédure insertRole pour insertion d'un rôle
CALL insertRole('Admin');
CALL insertRole('User');
CALL insertRole('Educational_member');
CALL insertRole('Adhérent');

--Procédure permettant de créer un utilisateur
CREATE OR REPLACE PROCEDURE insertUser(
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    idCivility INTEGER,
    personEmail VARCHAR(255),
    personPassword VARCHAR(70),
    idAddress INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
civilityId INTEGER;
BEGIN
    INSERT INTO connection (email, password)
    VALUES (personEmail, personPassword) RETURNING id INTO idConnection;

    SELECT id INTO civilityId
    FROM civility
    WHERE id = idCivility;

    INSERT INTO person (
        lastname,
        firstname,
        phone,
        id_civility,
        id_connection,
        id_address
    )
    VALUES (
        personLastname,
        personFirstname,
        personPhone,
        civilityId,
        idConnection,
        idAddress
    );
END;
$$;

--Appel de la procédure insertUser pour insertion d'un utilisateur
CALL insertUser('Durant', 'Patrick', '06 17 25 85 08', NULL, 'durand@patrick.fr', '123', NULL);
CALL insertUser('Grand-Berger', 'George', '', NULL, 'grand-berger@george.com', '123', NULL);
CALL insertUser('Vilain', 'Jérome', '07 43 29 71 04', NULL, 'vilain@jerome.net', '123', NULL);

--Procédure permettant de créer un utilisateur spéciale
CREATE OR REPLACE PROCEDURE insertUser(
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    idCivility INTEGER,
    personEmail VARCHAR(255),
    personPassword VARCHAR(70),
    idAddress INTEGER,
    idRole INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
civilityId INTEGER;
BEGIN
    INSERT INTO connection (email, password)
    VALUES (personEmail, personPassword) RETURNING id INTO idConnection;

    SELECT id INTO civilityId
    FROM civility
    WHERE id = idCivility;

    INSERT INTO person (
        lastname,
        firstname,
        phone,
        id_civility,
        id_connection,
        id_address,
        id_role
    )
    VALUES (
        personLastname,
        personFirstname,
        personPhone,
        civilityId,
        idConnection,
        idAddress,
        idRole
    );
END;
$$;

--Appel de la procédure insertUser surchargé pour insertion d'un utilisateur spéciale
CALL insertUser('Choukri', 'Najia', '06 98 23 14 58', NULL, 'evs.frouard@francas54.org', '123aze', NULL, 1);
CALL insertUser('Dupond', 'Guy', '07 29 46 82 31', NULL, 'dupond@gui.fr', '123', NULL, 3);
CALL insertUser('Jaffar', 'Kamal', '08 52 21 07 45', NULL, 'jaffar@Kamal.fr', '123', NULL, 4);

--Fonction permettant d'inserer une adresse et récupérer son identifiant
CREATE OR REPLACE FUNCTION insertAddress(
    personid INTEGER,
    addressStreetNumber VARCHAR(10),
    addressStreetName VARCHAR(100),
    addressStreetComplement VARCHAR(50),
    zipCode VARCHAR(10),
    cityName VARCHAR(50)
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
addressId INTEGER;
idAddressComplement INTEGER;
zipCodeResult VARCHAR(10);
codeZipCode VARCHAR(10);
cityNameResult VARCHAR(50);
idCity INTEGER;
idAddress INTEGER;
BEGIN
    SELECT id_address INTO addressId
    FROM person
    WHERE id = personId;

    IF addressId IS NOT NULL THEN
        UPDATE address_complement SET street_complement = addressStreetComplement
        WHERE id = addressId RETURNING id INTO idAddressComplement;

        SELECT code 
        FROM zip_code 
        WHERE code = zipCode INTO zipCodeResult;
        
        IF zipCodeResult = zipCode THEN
            UPDATE zip_code SET code = zipCode
            WHERE code = zipCode RETURNING code INTO codeZipCode;
        ELSE
            INSERT INTO zip_code (code)
            VALUES (zipCode) RETURNING code INTO codeZipCode;
        END IF;

        SELECT name 
        FROM city 
        WHERE name = cityName INTO cityNameResult;

        IF cityNameResult = cityName THEN
            UPDATE city SET name = cityName
            WHERE name = cityName RETURNING id INTO idCity;
        ELSE
            INSERT INTO city (name)
            VALUES (cityName) RETURNING id INTO idCity;
        END IF;

        UPDATE address SET street_number = addressStreetNumber,
                        street_name = addressStreetName,
                        id_address_complement = idAddressComplement,
                        code_zip_code = codeZipCode,
                        id_city = idCity
        WHERE id = addressId RETURNING id INTO idAddress;
    ELSE
        INSERT INTO address_complement (street_complement)
        VALUES (addressStreetComplement) RETURNING id INTO idAddressComplement;

        SELECT code 
        FROM zip_code 
        WHERE code = zipCode INTO zipCodeResult;
        
        IF zipCodeResult = zipCode THEN
            UPDATE zip_code SET code = zipCode
            WHERE code = zipCode RETURNING code INTO codeZipCode;
        ELSE
            INSERT INTO zip_code (code)
            VALUES (zipCode) RETURNING code INTO codeZipCode;
        END IF;

        SELECT name 
        FROM city 
        WHERE name = cityName INTO cityNameResult;

        IF cityNameResult = cityName THEN
            UPDATE city SET name = cityName
            WHERE name = cityName RETURNING id INTO idCity;
        ELSE
            INSERT INTO city (name)
            VALUES (cityName) RETURNING id INTO idCity;
        END IF;

        INSERT INTO address (street_number, street_name, id_address_complement, code_zip_code, id_city)
        VALUES (
            addressStreetNumber,
            addressStreetName,
            idAddressComplement,
            codeZipCode,
            idCity
        ) RETURNING id INTO idAddress;
    END IF;
    RETURN idAddress;
END;
$$;

--Procédure permettant de mofier un administrateur et de rattacher son adresse
CREATE OR REPLACE PROCEDURE updateAdministrator(
    personId INTEGER,
    userLastname VARCHAR(50),
    userFirstname VARCHAR(50),
    userPhone VARCHAR(20),
    idCivility INTEGER,
    connectionEmail VARCHAR(255),
    connectionPassword VARCHAR(70),
    addressStreetNumber VARCHAR(10),
    addressStreetName VARCHAR(100),
    addressStreetComplement VARCHAR(50),
    zipCode VARCHAR(10),
    cityName VARCHAR(50)
)
LANGUAGE plpgsql
AS $$
DECLARE
idAddress INTEGER;
civilityId INTEGER;
idConnection INTEGER;
BEGIN
    SELECT id INTO civilityId
    FROM civility
    WHERE id = idCivility;

    idAddress := insertAddress(
        personId,
        addressStreetNumber,
        addressStreetName,
        addressStreetComplement,
        zipCode,
        cityName
    );

    UPDATE connection SET email = connectionEmail,
                        password = connectionPassword
    WHERE email = connectionEmail RETURNING id INTO idConnection;

    UPDATE person SET lastname = userLastname,
                    firstname = userFirstname,
                    phone = userPhone,
                    id_civility = civilityId,
                    id_connection = idConnection,
                    id_address = idAddress
    WHERE id = personId;
END;
$$;

--Appel de la procédure updateAdministrateur pour mofifier les données de l'administrateur
CALL updateAdministrator(
    3,
    'Choukri',
    'Najia',
    '06 98 23 14 58',
    NULL,
    'evs.frouard@francas54.org',
    '123aze',
    '',
    'Rue Jean Cocteau',
    'Maison Prévert',
    '54390',
    'Frouard'
);

--Procédure permettant d'insérer un lien vers une image d'un avatar pour l'administrateur
CREATE OR REPLACE PROCEDURE insertAvatar(personId INTEGER, avatarPicture VARCHAR(255))
LANGUAGE plpgsql
AS $$
DECLARE
idAvatar INTEGER;
BEGIN
    INSERT INTO avatar (picture)
    VALUES (avatarPicture) RETURNING id INTO idAvatar;

    UPDATE person SET id_avatar = idAvatar
    WHERE id = personId;
END;
$$;

--Appel de la procédure insertAvatar pour ajouter un avatar à l'administrateur
CALL insertAvatar(3, 'assets/img/avatar/');

--Procédure permettant de créer un type de structure
CREATE OR REPLACE PROCEDURE insertTypeStructure(TypeStructureWording VARCHAR(100))
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO type_structure (wording)
    VALUES (TypeStructureWording);
END;
$$;

--Appel de la procédure insertTypeStructure pour insertion d'un type de structure
CALL insertTypeStructure('Ecole');
CALL insertTypeStructure('Maison de le solidarité');

--Procédure permettant de créer une structure avec ajout ou mise à jour de données
CREATE OR REPLACE PROCEDURE insertStructure(
    structureName VARCHAR(100),
    structurePhone VARCHAR(20),
    addressStreetNumber VARCHAR(10),
    addressStreetName VARCHAR(100),
    addressStreetComplement VARCHAR(50),
    zipCode VARCHAR(10),
    cityName VARCHAR(50),
    idTypeStructure INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
idAddress INTEGER;
BEGIN
    idAddress := insertAddress(
        NULL,
        addressStreetNumber,
        addressStreetName,
        addressStreetComplement,
        zipCode,
        cityName
    );

    INSERT INTO structure (name, phone, id_type_structure, id_address)
    VALUES (structureName, structurePhone, idTypeStructure, idAddress);
END;
$$;

--Appel de la procédure insertStructure pour insertion d'une structure rattachée à un type de structure
CALL insertStructure('Ecole Maternelle Paul Langevin', '03 83 49 30 75', '1', 'Rue Eugène Colvis', '', '54390', UPPER('Frouard'), 1);
CALL insertStructure('Ecole Maternelle Jean Zay', '03 83 49 00 71', '11', 'Rue du Bouhaut', '', '54390', UPPER('Frouard'), 1);
CALL insertStructure('Ecole Jules Ferry', '03 83 37 28 76', '10', 'Rue des Jardiniers', '', '54000', UPPER('Nancy'), 1);

--Procédure permettant d'insérer un logo pour une stucture
CREATE OR REPLACE PROCEDURE insertLogoStructure(structureId INTEGER, structureLogo VARCHAR(255))
LANGUAGE plpgsql
AS $$
DECLARE
BEGIN
    UPDATE structure SET logo = structureLogo
    WHERE id = structureId;
END;
$$;

--Appel de la procédure insertLogoStructure pour ajouter un logo à la structure
CALL insertLogoStructure(1, 'assets/img/logo/');

--Procédure permettant de créer une catégorie d'activité
CREATE OR REPLACE PROCEDURE insertCategory(categoryName VARCHAR(100))
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO category (name)
    VALUES (categoryName);
END;
$$;

--Appel de la procédure insertCategory pour insertion d'une catégorie d'activité
CALL insertCategory('Notre Programme hebdomadaire');
CALL insertCategory('Atelier Cuisine du Monde');
CALL insertCategory('Les festivités');
CALL insertCategory('Nos Sorties');


--Procédure permettant de créer une activité
CREATE OR REPLACE PROCEDURE insertActivity(
    activityTitle VARCHAR(150),
    activityAdditionalInformation VARCHAR(255),
    activityDateStart DATE,
    activityDateEnd DATE,
    activityHourStart TIME,
    activityHourEnd TIME,
    activityDescription TEXT,
    activityPicture VARCHAR(255),
    idCategory INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
activDate DATE;
BEGIN
    INSERT INTO activity (
        title,
        additional_information,
        date_start,
        date_end,
        hour_start,
        hour_end,
        description,
        picture,
        id_category
    )
    VALUES (
        activityTitle,
        activityAdditionalInformation,
        activityDateStart,
        activityDateEnd,
        activityHourStart,
        activityHourEnd,
        activityDescription,
        activityPicture,
        idCategory
    );
END;
$$;

--Appel de la procédure insertActivity pour insertion d'une activité rattachée à sa catégorie
CALL insertActivity('Cours de français (FLE)', 'Tous les Mardis/jeudis/Vendredis', NULL, NULL, NULL, NULL, '','', 1);
CALL insertActivity('TGP Spectacle Participatif', '"les hommes improbables"', '2023/05/13', NULL, '16:00', NULL, '', '', 2);
CALL insertActivity('Les Etats_Unis', '', '2023/06/02', NULL, '9:30', NULL, '', '', 3);
CALL insertActivity('CCAS Tournoi de Rugby', '"Gentleman Challenge"', '2023/05/14', NULL, '9:30', NULL, '', '', 4);

--Procédure permettant d'insérer une image pour une activité
CREATE OR REPLACE PROCEDURE insertPictureActivity(activityId INTEGER, activityPicture VARCHAR(255))
LANGUAGE plpgsql
AS $$
DECLARE
BEGIN
    UPDATE activity SET picture = activityPicture
    WHERE id = activityId;
END;
$$;

--Appel de la procédure insertPictureActivity pour ajouter une image à l'activité
CALL insertPictureActivity(1, 'assets/img/image_activity/');

--Procédure permettant d'uploader un document
CREATE OR REPLACE PROCEDURE insertDocument(
    documentName VARCHAR(50),
    documentLink VARCHAR(255),
    idStructure INTEGER,
    idTeacher INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
idDocument INTEGER;
documentDate DATE;
BEGIN
    SELECT yyyy_mm_dd
    FROM _date
    WHERE yyyy_mm_dd = CURRENT_DATE INTO documentDate;
   
    IF CURRENT_DATE = documentDate THEN
        UPDATE _date SET yyyy_mm_dd = CURRENT_DATE
        WHERE yyyy_mm_dd = CURRENT_DATE;
    ELSE
        INSERT INTO _date (yyyy_mm_dd)
        VALUES (NOW());
    END IF;

    INSERT INTO document (name, link, id_structure)
    VALUES (documentName, documentLink, idStructure) RETURNING id INTO idDocument;

    INSERT INTO upload (id_teacher, id_document)
    VALUES (idTeacher, idDocument);
END;
$$;

--Appel de la procédure isertDocument pour effectuer une insertion d'un document
CALL insertDocument('Devoir d''espagnol', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Devoir d''histoire', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Devoir d''anglais', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Devoir de français', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Cours de français', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Cours de d''histoire', 'projetEvs/assets/documents/', 1, 4);
CALL insertDocument('Devoir d''anglais', 'projetEvs/assets/documents/', 3, 4);
CALL insertDocument('Devoir de français', 'projetEvs/assets/documents/', 3, 4);
CALL insertDocument('Devoir d''espagnol', 'projetEvs/assets/documents/', 2, 4);
CALL insertDocument('Cours de français', 'projetEvs/assets/documents/', 2, 4);

--Procédure permettant d'effectuer une réservation d'activité
CREATE OR REPLACE PROCEDURE reservation(
    idActivity INTEGER,
    idPerson INTEGER,
    reservationStatus BOOLEAN,
    reservationNumber INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
reservationDate DATE;
BEGIN
    SELECT yyyy_mm_dd
    FROM _date
    WHERE yyyy_mm_dd = CURRENT_DATE INTO reservationDate;
    
    IF CURRENT_DATE = reservationDate THEN
        UPDATE _date SET yyyy_mm_dd = CURRENT_DATE
        WHERE yyyy_mm_dd = CURRENT_DATE;
    ELSE
        INSERT INTO _date (yyyy_mm_dd)
        VALUES (NOW());
    END IF;

    INSERT INTO reservation (
        id_activity,
        id_person,
        status,
        number_of_reservation
        )
    VALUES (idActivity, idPerson, reservationStatus, reservationNumber);
END;
$$;

--Appel de la procédure reservation pour effectuer une réservation d'une activité
CALL reservation(2, 5, TRUE, CAST(1 AS SMALLINT));
CALL reservation(3, 4, TRUE, CAST(1 AS SMALLINT));
CALL reservation(1, 1, TRUE, CAST(1 AS SMALLINT));

--Foction permettant d'insérer et de mettre à jour une personne
CREATE OR REPLACE FUNCTION insertUpdatePerson(
    personId INTEGER,
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    idCivility INTEGER,
    idAddress INTEGER
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
idPerson INTEGER;
civilityId INTEGER;
BEGIN
    SELECT id INTO idPerson
    FROM person
    WHERE id = personId;

    SELECT id INTO civilityId
    FROM civility
    WHERE id = idCivility;

    IF idPerson IS NOT NULL THEN
        UPDATE person SET lastname = personLastname,
                        firstname = personFirstname,
                        phone = personPhone,
                        id_civility = civilityId,
                        id_address = idAddress
        WHERE id = personId RETURNING id INTO idPerson;
    ELSE
        INSERT INTO person (
            lastname,
            firstname,
            phone,
            id_civility,
            id_address,
            id_role
        )
        VALUES (
            personLastname,
            personFirstname,
            personPhone,
            civilityId,
            idAddress,
            NULL
        ) RETURNING id INTO idPerson;
    END IF;
    
    RETURN idPerson;
END;
$$;

--Fonction permettant d'insérer et de mettre à jour un membre
CREATE OR REPLACE FUNCTION insertUpdateMember(
    memberBirthdate DATE,
    memberPlaceBirth VARCHAR(50),
    personId INTEGER,
    memberIdPair INTEGER,
    idMemberData INTEGER
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
memberId INTEGER;
registrationDate DATE;
idMember INTEGER;
BEGIN
    SELECT id INTO memberId
    FROM _member
    WHERE id_person = personId;

    IF memberId IS NULL THEN
        INSERT INTO _member (
                birthdate,
                place_of_birth,
                id_person,
                id_pair,
                id_member_data,
                registration_date
        )
        VALUES (
            memberBirthdate,
            memberPlaceBirth,
            personId,
            memberIdPair,
            idMemberData,
            NOW()
        ) RETURNING id INTO idMember;

        SELECT yyyy_mm_dd INTO registrationDate
        FROM _date
        WHERE yyyy_mm_dd = CURRENT_DATE;
        
        IF CURRENT_DATE = registrationDate THEN
            UPDATE _date SET yyyy_mm_dd = CURRENT_DATE
            WHERE yyyy_mm_dd = CURRENT_DATE;
        ELSE
            INSERT INTO _date (yyyy_mm_dd)
            VALUES (NOW());
        END IF;
    ELSE
        UPDATE _member SET birthdate = memberBirthdate,
                               place_of_birth = memberPlaceBirth,
                               id_person = personId,
                               id_pair = memberIdPair,
                               id_member_data = idMemberData
        WHERE id_person = personId RETURNING id INTO idMember;
    END IF;

    RETURN idMember;
END;
$$;

CREATE OR REPLACE FUNCTION insertUpdateMemberData(
    personId INTEGER,
    memberDataEmail VARCHAR(255),
    memberDataProfession VARCHAR(50),
    memberDataFamilySituation VARCHAR(50),
    memberDataCafNumber CHAR(10)
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
idMemberData INTEGER;
memberDataId INTEGER;
BEGIN
    SELECT id_member_data INTO idMemberData
    FROM _member
    WHERE id_person = personId;

    IF idMemberData IS NULL THEN
        INSERT INTO member_data (email, profession, family_situation, caf_number)
        VALUES (
            memberDataEmail,
            memberDataProfession,
            memberDataFamilySituation,
            memberDataCafNumber
        ) RETURNING id INTO memberDataId;
    ELSE
        UPDATE member_data SET email = memberDataEmail,
                               profession = memberDataProfession,
                               family_situation = memberDataFamilySituation,
                               caf_number = memberDataCafNumber
        WHERE id = idMemberData RETURNING id INTO memberDataId;
    END IF;

    RETURN memberDataId;
END;
$$;

--Fonction permettant de créer ou de mettre à jour un membre adulte avec son adresse et de retouner son id
CREATE OR REPLACE FUNCTION insertMemberAdult(
    personId INTEGER,
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    addressStreetNumber VARCHAR(10),
    addressStreetName VARCHAR(100),
    addressStreetComplement VARCHAR(50),
    zipCode VARCHAR(10),
    cityName VARCHAR(50),
    memberBirthdate DATE,
    memberPlaceBirth VARCHAR(50),
    memberIdPair INTEGER,
    memberDataEmail VARCHAR(255),
    memberDataProfession VARCHAR(50),
    memberDataFamilySituation VARCHAR(50),
    memberDataCafNumber CHAR(10),
    idCivility INTEGER
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
idAddress INTEGER;
idMemberData INTEGER;
idPerson INTEGER;
idMember INTEGER;
BEGIN
    idAddress := insertAddress(
        personId,
        addressStreetNumber,
        addressStreetName,
        addressStreetComplement,
        zipCode,
        cityName
    );

    idMemberData := insertUpdateMemberData(
        personId,
        memberDataEmail,
        memberDataProfession,
        memberDataFamilySituation,
        memberDataCafNumber
    );

    idPerson := insertUpdatePerson(
        personId,
        personLastname,
        personFirstname,
        personPhone,
        idCivility,
        idAddress
    );

    idMember := insertUpdateMember(
        memberBirthdate,
        memberPlaceBirth,
        idPerson,
        memberIdPair,
        idMemberData
    );

    RETURN idMember;
END;
$$;

--Appel de fonction permettant de créer ou de mettre à jour un membre adulte avec son adresse
SELECT insertMemberAdult(5, 'Jaffar', 'kamal', '08 52 21 07 45', '8', 'rue Marie Currie', '', '54130', 'Saint-Max', '1974/03/15', 'Nancy', NULL, 'jaffar@Kamal.fr', 'Comptable', 'Célibataire', '5128746H', 2);
SELECT insertMemberAdult(NULL, 'Jaffar', 'Mathilda', '08 67 20 49 62', '8', 'rue Marie Currie', '', '54130', 'Saint-Max', '1978/06/08', 'Nancy', 1, 'jaffar@mathilda.fr', 'Femme de ménage', 'Célibataire', '5139466H', 1);

--Fonction permettant de créer un membre mineur et rechercher si l'école lui est rattachée et de retourner son id
CREATE OR REPLACE FUNCTION insertMemberminor(
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    memberBirthdate DATE,
    memberPlaceBirth VARCHAR(50)
)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
idPerson INTEGER;
idMember INTEGER;
BEGIN
    idPerson := insertUpdatePerson(
            NULL,
            personLastname,
            personFirstname,
            personPhone,
            NULL,
            NULL
        );

    idMember := insertUpdateMember(
        memberBirthdate,
        memberPlaceBirth,
        idPerson,
        NULL,
        NULL
    );
    
    RETURN idMember;
END;
$$;

--Appel de fonction permettant de créer un membre mineur
-- SELECT insertMemberminor('Jaffar', 'Adrien', '06 26 02 81 74', '2005/08/13', 'Nancy');
-- SELECT insertMemberminor('Jaffar', 'Carole', '07 12 94 49 72', '2008/10/23', 'Nancy');

--Procédure permettant de rattacher un responsable avec un mineur et de rattacher son école si elle enregistré
CREATE OR REPLACE PROCEDURE attachResponsibleToMinor(
    supervisorSchool VARCHAR(100),
    supervisorSchoolCity VARCHAR(50),
    idStructure INTEGER,
    insertMemberminor INTEGER,
    insertMemberAdult INTEGER
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO supervisor (
        school,
        schoolCity,
        id_structure,
        id_member_not_responsible,
        id_member_is_responsible
    )
    VALUES (
        supervisorSchool,
        supervisorSchoolCity,
        idStructure,
        insertMemberminor,
        insertMemberAdult
    );
END;
$$;

CALL attachResponsibleToMinor(
    'Ecole Jules Ferry',
    'Nancy',
    NULL,
    insertMemberminor('Jaffar', 'Adrien', '06 26 02 81 74', '2005/08/13', 'Nancy'),
    insertMemberAdult(5, 'Jaffar', 'kamal', '08 52 21 07 45', '8', 'rue Marie Currie', '', '54130', 'Saint-Max', '1974/03/15', 'Nancy', NULL, 'jaffar@Kamal.fr', 'Comptable', 'Célibataire', '5128746H', 2)
);
CALL attachResponsibleToMinor(
    'Ecole Maternelle Jean Zay',
    'Frouard',
    NULL,
    insertMemberminor('Jaffar', 'Carole', '07 12 94 49 72', '2008/10/23', 'Nancy'),
    insertMemberAdult(5, 'Jaffar', 'kamal', '08 52 21 07 45', '8', 'rue Marie Currie', '', '54130', 'Saint-Max', '1974/03/15', 'Nancy', NULL, 'jaffar@Kamal.fr', 'Comptable', 'Célibataire', '5128746H', 2)
);

-- TRUNCATE _member, member_data CASCADE;
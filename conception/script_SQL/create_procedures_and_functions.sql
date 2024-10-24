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
    personEmail VARCHAR(255),
    personPassword VARCHAR(70)
)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
BEGIN
    INSERT INTO connection (email, password)
    VALUES (personEmail, personPassword) RETURNING id INTO idConnection;

    INSERT INTO person (
        lastname,
        firstname,
        id_connection
    )
    VALUES (
        personLastname,
        personFirstname,
        idConnection
    );
END;
$$;

--Appel de la procédure insertUser pour insertion d'un utilisateur
CALL insertUser('Durant', 'Patrick', 'durand@patrick.fr', '123');
CALL insertUser('Grand-Berger', 'George', 'grand-berger@george.com', '123');
CALL insertUser('Vilain', 'Jérome', 'vilain@jerome.net', '123');
CALL insertUser('Choukri', 'Najia', 'evs.frouard@francas54.org', '123aze');
CALL insertUser('Dupond', 'Guy', 'dupond@gui.fr', '123');
CALL insertUser('Jaffar', 'Kamal', 'jaffar@Kamal.fr', '123');

--Procédure permettant de modifier un utilisateur
CREATE OR REPLACE PROCEDURE updateUser(
    personId INTEGER,
    personLastname VARCHAR(50),
    personFirstname VARCHAR(50),
    personPhone VARCHAR(20),
    personEmail VARCHAR(255),
    personPassword VARCHAR(70)
)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
BEGIN
    SELECT id_connection INTO idConnection
    FROM person
    WHERE id = personId;

    UPDATE person SET lastname = personLastname,
                      firstname = personFirstname,
                      phone = personPhone
    WHERE id = personId;

    UPDATE connection SET email = personEmail,
                          password = personPassword
    WHERE id = idConnection;
END;
$$;

--Appel de la procédure updateUser pour la modification d'un utilisateur
CALL updateUser(2, 'Grand-Berger', 'George', '06 73 28 36 40', 'grand-berger@george.com', '123');
CALL updateUser(4, 'Choukri', 'Najia', '06 98 23 14 58', 'evs.frouard@francas54.org', '123aze');
CALL updateUser(5, 'Dupond', 'Guy', '07 29 46 82 31', 'dupond@gui.fr', '123');
CALL updateUser(6, 'Jaffar', 'Kamal', '08 52 21 07 45', 'jaffar@Kamal.fr', '123');

-- --Procédure permettant de créer un utilisateur spéciale
-- CREATE OR REPLACE PROCEDURE insertUser(
--     personLastname VARCHAR(50),
--     personFirstname VARCHAR(50),
--     personPhone VARCHAR(20),
--     idCivility INTEGER,
--     personEmail VARCHAR(255),
--     personPassword VARCHAR(70),
--     idAddress INTEGER,
--     idRole INTEGER
-- )
-- LANGUAGE plpgsql
-- AS $$
-- DECLARE
-- idConnection INTEGER;
-- civilityId INTEGER;
-- BEGIN
--     INSERT INTO connection (email, password)
--     VALUES (personEmail, personPassword) RETURNING id INTO idConnection;

--     SELECT id INTO civilityId
--     FROM civility
--     WHERE id = idCivility;

--     INSERT INTO person (
--         lastname,
--         firstname,
--         phone,
--         id_civility,
--         id_connection,
--         id_address,
--         id_role
--     )
--     VALUES (
--         personLastname,
--         personFirstname,
--         personPhone,
--         civilityId,
--         idConnection,
--         idAddress,
--         idRole
--     );
-- END;
-- $$;

--Procédure permettant de supprimer un utilisateur par son identifiant
CREATE OR REPLACE PROCEDURE deleteOneUser(personId INTEGER)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
BEGIN
    SELECT id_connection INTO idConnection
    FROM person 
    WHERE id = personId;

    DELETE FROM person
    WHERE id = personId;

    DELETE FROM connection
    WHERE id = idConnection;
END;
$$;


--Procédure permettant de modifier le rôle d'un utilisateur
CREATE OR REPLACE PROCEDURE updateRoleUser(personId INTEGER, idRole INTEGER)
LANGUAGE plpgsql
AS $$
DECLARE
idConnection INTEGER;
BEGIN
    UPDATE person SET id_role = idRole      
    WHERE id = personId;
END;
$$;

--Appel de la procédure updateRoleUser pour la modification du rôle d'un utilisateur
CALL updateRoleUser(4, 1);
CALL updateRoleUser(5, 3);
CALL updateRoleUser(6, 4);

--Appel de la procédure insertUser surchargé pour insertion d'un utilisateur spéciale
-- CALL insertUser('Choukri', 'Najia', '06 98 23 14 58', NULL, 'evs.frouard@francas54.org', '123aze', NULL, 1);
-- CALL insertUser('Dupond', 'Guy', '07 29 46 82 31', NULL, 'dupond@gui.fr', '123', NULL, 3);
-- CALL insertUser('Jaffar', 'Kamal', '08 52 21 07 45', NULL, 'jaffar@Kamal.fr', '123', NULL, 4);

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
    4,
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

--Procédure permettant de créer une catégorie d'activité et de la ranger dans un thème
CREATE OR REPLACE PROCEDURE insertCategory(
    categoryName VARCHAR(100),
    categoryEvent INTEGER
    )
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO category (name, event)
    VALUES (categoryName, categoryEvent);
END;
$$;

--Appel de la procédure insertCategory pour insertion d'une catégorie d'activité
CALL insertCategory('Notre Programme hebdomadaire', CAST(1 AS SMALLINT));
CALL insertCategory('Atelier Cuisine du Monde', CAST(2 AS SMALLINT));
CALL insertCategory('Les festivités', CAST(1 AS SMALLINT));
CALL insertCategory('Nos Sorties', CAST(2 AS SMALLINT));


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
    activityMaturity INTEGER,
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
        maturity,
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
        activityMaturity,
        idCategory
    );
END;
$$;

--Appel de la procédure insertActivity pour insertion d'une activité rattachée à sa catégorie
CALL insertActivity('Cours de français (FLE)', 'Tous les Mardis/jeudis/Vendredis', NULL, NULL, NULL, NULL, '','', 1, 1);
CALL insertActivity('TGP Spectacle Participatif', '"les hommes improbables"', '2023/05/13', NULL, '16:00', NULL, '', '', 1, 2);
CALL insertActivity('Les Etats_Unis', '', '2023/06/02', NULL, '9:30', NULL, '', '', 1, 3);
CALL insertActivity('CCAS Tournoi de Rugby', '"Gentleman Challenge"', '2023/05/14', NULL, '9:30', NULL, '', '', 1, 4);

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
   
    IF documentDate IS NULL THEN
    INSERT INTO _date (yyyy_mm_dd)
    VALUES (CURRENT_DATE);
    END IF;

    INSERT INTO document (name, link, id_structure)
    VALUES (documentName, documentLink, idStructure) RETURNING id INTO idDocument;

    INSERT INTO upload (id_teacher, id_document)
    VALUES (idTeacher, idDocument);
END;
$$;

--Appel de la procédure isertDocument pour effectuer une insertion d'un document
CALL insertDocument('Devoir d''espagnol', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Devoir d''histoire', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Devoir d''anglais', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Devoir de français', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Cours de français', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Cours de d''histoire', 'projetEvs/assets/documents/', 1, 2);
CALL insertDocument('Devoir d''anglais', 'projetEvs/assets/documents/', 3, 2);
CALL insertDocument('Devoir de français', 'projetEvs/assets/documents/', 3, 2);
CALL insertDocument('Devoir d''espagnol', 'projetEvs/assets/documents/', 2, 2);
CALL insertDocument('Cours de français', 'projetEvs/assets/documents/', 2, 2);

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
    
    IF reservationDate IS NULL THEN
    INSERT INTO _date (yyyy_mm_dd)
    VALUES (CURRENT_DATE);
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
CALL reservation(3, 2, TRUE, CAST(1 AS SMALLINT));
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

    SELECT yyyy_mm_dd INTO registrationDate
    FROM _date
    WHERE yyyy_mm_dd = CURRENT_DATE;
    
    IF registrationDate IS NULL THEN
    INSERT INTO _date (yyyy_mm_dd)
    VALUES (CURRENT_DATE);
    END IF;

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
            CURRENT_DATE
        ) RETURNING id INTO idMember;

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

--Fonction permetant d'inserer ou de mettre à jour des données d'un membre
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
idPerson INTEGER;
memberDataId INTEGER;
BEGIN
    SELECT id_person INTO idPerson
    FROM _member
    WHERE id_person = personId;

    IF idPerson IS NULL THEN
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
        WHERE id = idPerson RETURNING id INTO memberDataId;
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
SELECT insertMemberAdult(5, 'Jaffar', 'kamal', '08 52 21 07 45', '8', 'rue Marie Currie', '', '54130', 'Saint-Max', '1974/03/15', 'Nancy', NULL, 'jaffar@kamal.fr', 'Comptable', 'Célibataire', '5128746H', 2);
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
        school_city,
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

--Fonction qui permet de retouner un nom de catégorie en fonction d'un id
CREATE OR REPLACE FUNCTION displayOneCategory(idCategory INTEGER)
RETURNS TABLE (
    name VARCHAR(100)
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT category.name 
    FROM category 
    WHERE category.id = idCategory;
END
$$;

--Fonction permettant d'afficher un utilisateur grâce à son mail
CREATE OR REPLACE FUNCTION displayOneUserByEmail(userEmail VARCHAR(255))
RETURNS TABLE (
    id INTEGER,
    email VARCHAR(255),
    password VARCHAR(70),
    id_role INTEGER,
    name VARCHAR(50)
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT person.id, connection.email, connection.password, person.id_role, role.name
    FROM person
    JOIN connection ON person.id_connection = connection.id
    JOIN role ON person.id_role = role.id
    WHERE connection.email = userEmail;
END;
$$;

--Fonction permettant d'afficher un utilisateur grâce à son identifiant
CREATE OR REPLACE FUNCTION displayOneUserById(personId INTEGER)
RETURNS TABLE (
    lastname VARCHAR(50),
    firstname VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(255),
    password VARCHAR(70)
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT person.lastname, person.firstname, person.phone, connection.email, connection.password
    FROM person
    JOIN connection ON person.id_connection = connection.id
    WHERE person.id = personId;
END;
$$;

--Fonction permettant d'afficher un membre adulte grâce l'identifiant de la table person
CREATE OR REPLACE FUNCTION displayOneMember(personId INTEGER)
RETURNS TABLE (id INTEGER, member_info TEXT, member_address TEXT)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT _member.id, (
        SELECT string_agg(p.member_info, ', ')
        FROM (
            SELECT (
                civility.name || ', ' ||
                lastname || ', ' ||
                firstname || ', ' ||
                COALESCE(phone, '') || ', ' ||
                birthdate || ', ' ||
                place_of_birth || ', ' ||
                COALESCE(email, '') || ', ' ||
                COALESCE(profession, '') || ', ' ||
                COALESCE(family_situation, '') || ', ' ||
                caf_number
            ) AS member_info
            FROM _member
            JOIN member_data ON _member.id_member_data = member_data.id
            JOIN person ON _member.id_person = person.id
            JOIN civility ON person.id_civility = civility.id
            WHERE _member.id_person = personId
        ) p
    ), (
        SELECT string_agg(p.member_address, ', ')
        FROM (
            SELECT (
                COALESCE(street_number, '') || ', ' ||
                street_name || ', ' ||
                COALESCE(street_complement, '') || ', ' ||
                code || ', ' ||
                city.name
            ) AS member_address
            FROM _member
            JOIN person ON _member.id_person = person.id
            JOIN address ON person.id_address = address.id
            JOIN address_complement ON address.id_address_complement = address_complement.id
            JOIN zip_code ON address.code_zip_code = zip_code.code
            JOIN city ON address.id_city = city.id
            WHERE _member.id_person = personId
        ) p
    )
    FROM _member 
    WHERE _member.id_person = personId;
END;
$$;

--Fonction permettant d'afficher un membre lié au membre principal grâce à son identifiant
CREATE OR REPLACE FUNCTION displayOneMemberPair(memberId INTEGER)
RETURNS TABLE (id INTEGER, member_pair_info TEXT, member_pair_address TEXT)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT _member.id, (
        SELECT string_agg(m.member_pair_info, ', ')
        FROM (
            SELECT (
                civility.name || ', ' ||
                lastname || ', ' ||
                firstname || ', ' ||
                COALESCE(phone, '') || ', ' ||
                birthdate || ', ' ||
                place_of_birth || ', ' ||
                COALESCE(email, '') || ', ' ||
                COALESCE(profession, '') || ', ' ||
                COALESCE(family_situation, '') || ', ' ||
                caf_number
            ) AS member_pair_info
            FROM person
            JOIN member_data ON _member.id_member_data = member_data.id
            JOIN civility ON person.id_civility = civility.id
            WHERE _member.id_person = person.id
        ) m 
    ) , (
        SELECT string_agg(m.member_pair_address, ', ')
        FROM (
            SELECT (
                COALESCE(street_number, '') || ', ' ||
                street_name || ', ' ||
                COALESCE(street_complement, '') || ', ' ||
                code || ', ' ||
                city.name
            ) AS member_pair_address
            FROM person
            JOIN address ON person.id_address = address.id
            LEFT JOIN address_complement ON address.id_address_complement = address_complement.id
            JOIN zip_code ON address.code_zip_code = zip_code.code
            JOIN city ON address.id_city = city.id
            WHERE _member.id_person = person.id
        ) m
    )
    FROM _member
    WHERE _member.id_pair = memberId;
END;
$$;

--Fonction permettant d'afficher tous les membres mineurs de manière récursive grâce à l'identifiant de son responsable
CREATE OR REPLACE FUNCTION displayChildrenOfMember(memberId INTEGER)
RETURNS TABLE (id INTEGER, child_info TEXT, school_info_or_name TEXT)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    WITH RECURSIVE children AS (
        SELECT supervisor.id, (
            SELECT string_agg(c.child_info, ', ')
            FROM (
                SELECT (
                    child.lastname || ', ' ||
                    child.firstname || ', ' ||
                    COALESCE(child.phone, '') || ', ' ||
                    _member.birthdate || ', ' ||
                    _member.place_of_birth
                ) AS child_info
                FROM _member
                JOIN person AS child ON _member.id_person = child.id
                WHERE supervisor.id_member_not_responsible = _member.id
            ) c
        ), COALESCE(
            (
                SELECT string_agg(s.school_info, ', ')
                FROM (
                    SELECT (
                        school.name || ', ' ||
                        COALESCE(school.logo, '') || ', ' ||
                        school.phone || ', ' ||
                        COALESCE(sch_add.street_number, '') || ', ' ||
                        sch_add.street_name || ', ' ||
                        COALESCE(sch_add_compl.street_complement, '') || ', ' ||
                        sch_zip_code.code || ', ' ||
                        sch_city.name
                    ) AS school_info
                    FROM structure AS school
                    JOIN address AS sch_add ON school.id_address = sch_add.id
                    JOIN address_complement AS sch_add_compl ON sch_add.id_address_complement = sch_add_compl.id
                    JOIN zip_code AS sch_zip_code ON sch_add.code_zip_code = sch_zip_code.code
                    JOIN city AS sch_city ON sch_add.id_city = sch_city.id
                    WHERE supervisor.id_structure = school.id
                ) s 
            ), supervisor.school
        ) AS school_info_or_name
        FROM supervisor
        WHERE supervisor.id_member_is_responsible = memberId
        GROUP BY supervisor.id
        UNION
        SELECT sup.id, (
            SELECT string_agg(c.child_info, ', ')
            FROM (
                SELECT (
                    child.lastname || ', ' ||
                    child.firstname || ', ' ||
                    COALESCE(child.phone, '') || ', ' ||
                    child_member.birthdate || ', ' ||
                    child_member.place_of_birth
                ) AS child_info
                FROM _member AS child_member
                JOIN person AS child ON child_member.id_person = child.id
                WHERE sup.id_member_not_responsible = child_member.id
            ) c
        ), COALESCE(
            (
                SELECT string_agg(s.school_info, ', ')
                FROM (
                    SELECT (
                        school.name || ', ' ||
                        COALESCE(school.logo, '') || ', ' ||
                        school.phone || ', ' ||
                        COALESCE(sch_add.street_number, '') || ', ' ||
                        sch_add.street_name || ', ' ||
                        COALESCE(sch_add_compl.street_complement, '') || ', ' ||
                        sch_zip_code.code || ', ' ||
                        sch_city.name
                    ) AS school_info
                    FROM structure AS school
                    JOIN address AS sch_add ON school.id_address = sch_add.id
                    JOIN address_complement AS sch_add_compl ON sch_add.id_address_complement = sch_add_compl.id
                    JOIN zip_code AS sch_zip_code ON sch_add.code_zip_code = sch_zip_code.code
                    JOIN city AS sch_city ON sch_add.id_city = sch_city.id
                    WHERE sup.id_structure = school.id
                ) s 
            ), sup.school
        ) AS school_info_or_name
        FROM supervisor AS sup
        JOIN children AS c ON sup.id_member_is_responsible = c.id
    )
    SELECT * FROM children;
END;
$$;

--Fonction permettant d'afficher tous les membres d'une famille rattachés au membre principal
CREATE OR REPLACE FUNCTION displayAllMemberById(personId INTEGER)
RETURNS TABLE (displayMember TEXT, displayPair TEXT, displayChild TEXT[])
LANGUAGE plpgsql
AS $$
DECLARE
displayMember TEXT;
displayPair TEXT;
displayChild TEXT[];

memberId INTEGER;
memberIdPair INTEGER;
memberIdNotResponsible INTEGER;
BEGIN
    displayMember := displayOneMember(personId);

    SELECT id INTO memberId
    FROM _member
    WHERE _member.id_person = personId;

    SELECT id_pair INTO memberIdPair
    FROM _member
    WHERE _member.id_pair = memberId;
    
    IF memberIdPair = memberId THEN
        displayPair := displayOneMemberPair(memberId);
    END IF;

    SELECT id_member_not_responsible INTO memberIdNotResponsible
    FROM supervisor
    WHERE supervisor.id_member_is_responsible = memberId;

    IF memberIdNotResponsible IS NOT NULL THEN
        SELECT ARRAY(SELECT displayChildrenOfMember(memberId)) INTO displayChild;
    END IF;

    RETURN QUERY SELECT displayMember, displayPair, displayChild;
END;
$$;

-- TRUNCATE _member, member_data CASCADE;
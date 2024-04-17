--Vue permettant d'afficher toutes les civilités
CREATE OR REPLACE VIEW displayAllCivility
AS
SELECT civility.id, civility.name
FROM civility;

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
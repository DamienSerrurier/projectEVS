--Fonction permettant de vérifier s'il existe un identifiant en fonction d'un nom d'école et l'assigner le cas échéant dans la table supervisor
CREATE OR REPLACE FUNCTION addSchoolIfExistInSupervised()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
DECLARE
structureId INTEGER;
structureName VARCHAR(100);
structureIdAddress INTEGER;
cityName VARCHAR(50);
idCity INTEGER;
BEGIN 
    SELECT id, name, id_address
    INTO structureId, structureName, structureIdAddress
    FROM structure
    WHERE name = NEW.school;

    SELECT id_city
    INTO idCity
    FROM address
    WHERE id = structureIdAddress;

    SELECT name
    INTO cityName
    FROM city
    WHERE id = idCity;

    IF structureName = NEW.school AND cityName = UPPER(NEW.school_city) THEN
        NEW.id_structure = structureId;
    END IF;
    RETURN NEW;
END;
$$;

--Trigger permettant de déclancher la fonction addSchoolIfExistInSupervised
CREATE OR REPLACE TRIGGER trigger_addSchoolIfExistInSupervised
BEFORE INSERT ON supervisor
FOR EACH ROW
EXECUTE FUNCTION addSchoolIfExistInSupervised();
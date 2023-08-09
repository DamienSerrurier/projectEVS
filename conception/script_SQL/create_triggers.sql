--Fonction permettant de vérifier s'il existe un identifiant en fonction d'un nom d'école et l'assigner le cas échéant dans la table supervisor
CREATE OR REPLACE FUNCTION addSchoolIfExistInSupervised()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
DECLARE
structureId INTEGER;
structureName VARCHAR(100);
BEGIN 
    SELECT id, name
    INTO structureId, structureName
    FROM structure
    WHERE name = NEW.school;

    IF structureName = NEW.school THEN
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
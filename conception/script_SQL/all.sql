--Nettoyage de la console et création d'un fichier log
\! clear
\o sql.log

--Suppressions des tables, des triggers, des procédures, des fonctions et des vues
\i drop_views.sql
\echo VIEWS DROPPED
\i drop_procedures_and_functions.sql
\echo PROCEDURES AND FUNCTIONS DROPPED
\i drop_triggers.sql
\echo TRIGGERS DROPPED
\i drop_tables.sql
\echo TABLES DROPPED

--Creations de tables, des triggers, des procédures, des fonctions et des vues
\i create_tables.sql
\echo TABLES CREATED
\i create_triggers.sql
\echo TRIGGERS CREATED
\i create_procedures_and_functions.sql
\echo PROCEDURES AND FUNCTIONS CREATED
\i create_views.sql
\echo VIEWS CREATED

\o
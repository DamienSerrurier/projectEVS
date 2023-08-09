DROP PROCEDURE attachResponsibleToMinor,
               insertActivity,
               insertAvatar,
               insertCategory,
               insertDocument,
               insertLogoStructure,
               insertPictureActivity,
               insertRole,
               insertStructure,
               insertTypeStructure,
               reservation,
               updateAdministrator;

DROP PROCEDURE insertUser(
    IN personlastname character varying,
    IN personfirstname character varying,
    IN personphone character varying,
    IN idcivility integer,
    IN personemail character varying,
    IN personpassword character varying,
    IN idaddress integer
);

DROP PROCEDURE insertUser(
    IN personlastname character varying,
    IN personfirstname character varying,
    IN personphone character varying,
    IN idcivility integer,
    IN personemail character varying,
    IN personpassword character varying,
    IN idaddress integer,
    IN idrole integer
);

DROP FUNCTION insertUpdatePerson,
              insertUpdateMemberData,
              insertUpdateMember,
              insertMemberminor,
              insertMemberAdult,
              insertAddress,
              displayOneMemberPair,
              displayOneMember,
              displayChildrenOfMember,
              displayAllMemberById;

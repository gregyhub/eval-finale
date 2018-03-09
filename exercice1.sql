SELECT a.id, a.title, a.content, a.picture, a.date_publish, u.id, u.firstname, u.lastname
    WHERE u.id=a.id_user
    AND a.id=10;
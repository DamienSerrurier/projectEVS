<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Espace de Vie Social - Connexion compte utilisateur</title>
</head>

<body>
    <?php
    require_once 'partials/navbar.php';
    ?>

    <form action="">
        <div>
            <h2>Connexion compte utilisateur</h2>
        </div>

        <div>
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail">
        </div>

        <div>
            <label for="passw">Mot de passe</label>
            <input type="password" name="passw" id="passw">
        </div>

        <div>
            <input type="button" name="" value="Retour">
            <input type="submit" name="" value="Création">
        </div>
    </form>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>
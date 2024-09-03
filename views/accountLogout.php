<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Espace de Vie Social - Déconnexion du compte</title>
</head>

<body>
    <?php
    require_once 'partials/navbar.php';
    ?>

    <div class="border py-3 mb-lg-5">
        <h2 class="text-center">Déconnexion compte</h2>
    </div>
    <div class="container p-4 col-xl-5">
        <fieldset class="border border-dark border-2 rounded-3 bg-light py-5">
            <legend class="text-center">Deconnexion compte Utilisateur</legend>
            <div class="row justify-content-center align-items-center px-3">
                <p class="text-center">Êtes-vous sûr de vouloir vous déconnecter ?</p>
                <div class="d-flex justify-content-around px-1">
                    <form action="accountLogout" method="post">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <button class="btn btn-success text-uppercase" type="submit" name="logout">Oui</button>
                    </form>
                    <?php
                    if (isset($_SESSION['user']['name']) && $_SESSION['user']['name'] == "Admin") :
                    ?>
                        <a href="administratorSpace">
                            <button class="btn btn-secondary text-uppercase">Nom</button>
                        </a>
                    <?php
                    else :
                    ?>
                        <a href="userSpace">
                            <button class="btn btn-secondary text-uppercase">Non</button>
                        </a>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </fieldset>

    </div>

    <div>
    </div>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
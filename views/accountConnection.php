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

    <form action="accountConnection" method="post">
        <div class="border py-3 mb-lg-5">
            <h2 class="text-center">Connexion compte utilisateur</h2>
        </div>

        <div class="container p-4 col-xl-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-5 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="mail">Adresse de méssagerie</label>
                </div>
                <div class="col-sm-10 col-md-4 col-xl-6 m-xl-3 my-xl-4 mb-3">
                    <input class=" form-control form-control-lg" placeholder="" aria-label="Renseignez votre adresse électronique" type="email" name="mail" id="mail">
                    <p class="text-danger m-0"><?= isset($infoMessages['mail']) && !empty($infoMessages['mail']) ? htmlspecialchars($infoMessages['mail']) : '' ?></p>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-5 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="passw">Mot de passe</label>
                </div>
                <div class="col-sm-10 col-md-4 col-xl-6 m-xl-3 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre mot de passe" type="password" name="passw" id="passw">
                    <p class="text-danger m-0"><?= isset($infoMessages['passw']) && !empty($infoMessages['passw']) ? htmlspecialchars($infoMessages['passw']) : '' ?></p>
                </div>
            </div>
        </div>
        
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

        <div class="container p-4 col-xl-5 d-none d-sm-block">
            <div class="row justify-content-between">
                <input class="col-md-4 col-xl-4 p-2 text-uppercase my-3" type="button" name="" value="Retour">
                <input class="col-md-4 col-xl-4 p-2 text-uppercase my-3" type="submit" name="userConnection" value="Connexion">
            </div>
        </div>

        <div class="container col-6 p-4 d-block d-sm-none">
            <div class="row">
                <input class="col-sm-7 p-2 text-uppercase my-3 mt-0" type="submit" name="userConnection" value="Connexion">
                <input class="col-sm-7 p-2 text-uppercase my-3" type="button" name="" value="Retour">
            </div>
        </div>
    </form>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
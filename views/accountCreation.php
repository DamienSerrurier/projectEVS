<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Espace de Vie Social - Création de compte utilisateur</title>
</head>

<body>
    <?php
    require_once 'partials/navbar.php';
    ?>

    <form action="accountCreation" method="post">
        <div class="border py-3 mb-lg-5">
            <h2 class="text-center">Création compte utilisateur</h2>
        </div>

        <div class="container p-4 col-xl-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-4 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="lastname">Nom</label>
                </div>

                <div class="col-xl-7 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre Nom" type="text" name="lastname" id="lastname">
                    <p class="text-danger m-0"><?= isset($infoMessages['lastname']) && !empty($infoMessages['lastname']) ? htmlspecialchars($infoMessages['lastname']) : '' ?></p>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-4 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="firstname">Prénom</label>
                </div>

                <div class="col-xl-7 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre Prénom" type="text" name="firstname" id="firstname">
                    <p class="text-danger m-0"><?= isset($infoMessages['firstname']) && !empty($infoMessages['firstname']) ? htmlspecialchars($infoMessages['firstname']) : '' ?></p>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-4 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="mail">Email</label>
                </div>

                <div class="col-xl-7 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre adresse mail" type="email" name="mail" id="mail">
                    <p class="text-danger m-0"><?= isset($infoMessages['mail']) && !empty($infoMessages['mail']) ? htmlspecialchars($infoMessages['mail']) : '' ?></p>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-4 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="passw">Création du mot de passe</label>
                </div>

                <div class="col-xl-7 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre mot de passe" type="password" name="passw" id="passw">
                    <p class="text-danger m-0"><?= isset($infoMessages['passw']) && !empty($infoMessages['passw']) ? htmlspecialchars($infoMessages['passw']) : '' ?></p>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-10 col-md-4 col-xl-4 text-xl-end text-center">
                    <label class="col-form-label-xl-end" for="confPassw">Confirmation mot de passe</label>
                </div>
                
                <div class="col-xl-7 my-xl-4 mb-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Confirmez votre mot de passe" type="password" name="confPassw" id="confPassw">
                    <p class="text-danger m-0"><?= isset($infoMessages['confPassw']) && !empty($infoMessages['confPassw']) ? htmlspecialchars($infoMessages['confPassw']) : '' ?></p>
                </div>
            </div>
        </div>

        <div class="container p-4 col-xl-5 d-none d-sm-block">
            <div class="row justify-content-between">
                <input class="col-md-4 col-xl-4 p-2 text-uppercase my-3" type="button" name="" value="Annulation">
                <input class="col-md-4 col-xl-4 p-2 text-uppercase my-3" type="submit" name="userCreate" value="Création">
            </div>
        </div>

        <div class="container col-6 p-4 d-block d-sm-none">
            <div class="row">
                <input class="col-sm-7 p-2 text-uppercase my-3" type="submit" name="userCreate" value="Création">
                <input class="col-sm-7 p-2 text-uppercase my-3" type="button" name="" value="Annulation">
            </div>
        </div>
    </form>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
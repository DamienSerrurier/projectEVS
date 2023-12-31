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

    <form action="">
        <div class="border py-3 mb-lg-5">
            <h2 class="text-center">Création compte utilisateur</h2>
        </div>

        <div class="container p-4 col-xl-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-4 col-sm-10 text-xl-end text-center">
                    <label class="col-form-label-xl fs-6" for="lastname">Nom</label>
                </div>

                <div class="col-xl-7 my-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre Nom" type="text" name="lastname" id="lastname">
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-xl-4 col-sm-10 text-xl-end text-center">
                    <label class="col-form-label-xl fs-6" for="firstname">Prénom</label>
                </div>

                <div class="col-xl-7 my-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre Prénom" type="text" name="firstname" id="firstname">
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-xl-4 col-sm-10 text-xl-end text-center">
                    <label class="col-form-label-xl fs-6" for="mail">Email</label>
                </div>

                <div class="col-xl-7 my-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre adresse mail" type="email" name="mail" id="mail">
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-xl-4 col-sm-10 text-xl-end text-center">
                    <label class="col-form-label-xl fs-6" for="passw">Création du mot de passe</label>
                </div>

                <div class="col-xl-7 my-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Renseignez votre mot de passe" type="password" name="passw" id="passw">
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-xl-4 col-sm-10 text-xl-end text-center">
                    <label class="col-form-label-xl fs-6" for="confPassw">Confirmation mot de passe</label>
                </div>

                <div class="col-xl-7 my-3">
                    <input class="form-control form-control-lg" placeholder="" aria-label="Confirmez votre mot de passe" type="password" name="confPassw" id="confPassw">
                </div>
            </div>
        </div>

        <div class="container col-12 d-none d-sm-block">
            <div class="d-flex justify-content-around mt-3">
                <input class="p-2 text-uppercase" type="button" name="" value="Annulation">
                <input class="p-2 text-uppercase" type="submit" name="" value="Création">
            </div>
        </div>

        <div class="container col-4 d-block d-sm-none">
            <div class="row">
                <input class="p-2 text-uppercase my-3" type="submit" name="" value="Création">
                <input class="p-2 text-uppercase my-3" type="button" name="" value="Annulation">
            </div>
        </div>
    </form>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
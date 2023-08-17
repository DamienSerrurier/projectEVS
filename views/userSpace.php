<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Espace de Vie Social - Espace utilisateur</title>
</head>

<body>
    <?php
    require_once 'partials/navbar.php';
    ?>

    <section>
        <div class="border py-3 mb-lg-5">
            <h2 class="text-center">Espace utilisateur</h2>
        </div>

        <form action="">
            <div class="container p-4">
            <p class="text-danger m-0"><?= isset($infoMessages['id']) && !empty($infoMessages['id']) ? htmlspecialchars($infoMessages['id']) : '' ?></p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="member" id="member">
                    <label class="form-label-lg fs-6" for="member">J'adhère à l'association EVS Maison Prévert</label>
                </div>

                <div class="row justify-content-between">
                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="responsibleSelect">Nombre de responsable</label>
                        <select class="form-select form-select-lg my-2 fs-6" name="responsible" id="responsibleSelect">
                            <option value="">responsable</option>
                            <option value="responsible1" selected>1 responsable</option>
                            <option value="responsible2">2 responsables</option>
                        </select>
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-2">
                        <div class="border text-center">
                            <p>Cotisation annuelle:</p>
                            <ul>
                                <li>5/Adulte</li>
                                <li>2/Mineur</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <fieldset class="border p-4 mt-5" form="">
                    <legend class="col-form-label-lg">Informations personnelles</legend>

                    <input class="form-check-input" type="radio" name="civility" id="choiceWoman" value="woman">
                    <label class="form-label-lg fs-6" for="choiceWoman">Madame</label>

                    <input class="form-check-input" type="radio" name="civility" id="choiceMan" value="man">
                    <label class="form-label-lg fs-6" for="choiceMan">Monsieur</label>

                    <div class="row">
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberLastname">Nom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom" type="text" name="memberLastname" id="memberLastname">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberFirstname">Prénom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un prénom" type="text" name="memberFirstname" id="memberFirstname">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberMail">Adresse mail</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un émail" type="email" name="memberMail" id="memberMail">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberPphone">Téléphone</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de téléphone" type="tel" name="memberPphone" id="memberPphone">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberBirthdate">Date de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez une date de naissance" type="date" name="memberBirthdate" id="memberBirthdate">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="memberBirthPlace">Lieu de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom" type="text" name="memberBirthPlace" id="memberBirthPlace">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5" form="">
                    <legend class="col-form-label-lg">Informations habitation</legend>

                    <div class="row justify-content-end">
                        <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                            <label class="form-label-lg fs-6" for="memberStreetNumber">Numéro de rue</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de rue" type="text" name="memberStreetNumber" id="memberStreetNumber">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-9 mt-3">
                            <label class="form-label-lg fs-6" for="memberStreetName">Nom de rue</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom de rue" type="text" name="memberStreetName" id="memberStreetName">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-7 mt-3">
                            <label class="form-label-lg fs-6" for="memberStreetComplement">Complément
                                d'adresse</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un complément d'adresse" type="text" name="memberStreetComplement" id="memberStreetComplement">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                            <label class="form-label-lg fs-6" for="memberZipCode">Code postal</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un code postal" type="text" name="memberZipCode" id="memberZipCode">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-2 mt-3">
                            <label class="form-label-lg fs-6" for="memberCity">Ville</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez une ville" type="text" name="memberCity" id="memberCity">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5 mb-2" form="">
                    <legend class="col-form-label-lg">Informations de situation</legend>

                    <div class="row">
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="profession">Profession</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Une profession" type="text" name="profession" id="profession">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="familySituation">Situation de famille</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="une situation de famille" type="text" name="familySituation" id="familySituation">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="cafNumber">Numéro d'identifiant d'allocation
                                familiale</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="un numéro d'identifiant d'allocation
                                familiale" type="text" name="cafNumber" id="cafNumber">
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="minorSelect">Nombre de mineurs</label>
                        <select class="form-select form-select-lg my-2 fs-6" name="minor" id="minorSelect">
                            <option value="">mineur</option>
                            <option value="minor1" selected>1 mineur</option>
                            <option value="minor2">2 mineurs</option>
                        </select>
                    </div>
                </div>

                <fieldset class="border p-4 mt-3 mb-5">
                    <div class="row">
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childLastname">Nom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom d'enfant" type="text" name="childLastname" id="childLastname">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childFirstname">Prénom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un prénom d'enfant" type="text" name="childFirstname" id="childFirstname">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childBirthdate">Date de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez la date de naissance d'un enfant" type="date" name="childBirthdate" id="childBirthdate">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childBirthPlace">Lieu de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un lieu de naissance d'un enfant" type="text" name="childBirthPlace" id="childBirthPlace">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childPhone">Téléphone</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de téléphone d'un enfant" type="tel" name="childPhone" id="childPhone">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childSchool">Ecole</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom d'école de l'enfant" type="text" name="childSchool" id="childSchool">
                        </div>
                    </div>
                </fieldset>

                <p>
                    Je cotise en conséquence à cet Espace de Vie Sociale Maison Prévert Francas et m’inscris aux
                    activités
                    proposées.
                </p>
                <p>
                    J’ai été informé que la cotisation à l’Espace de Vie Sociale Maison Prévert Francas me permet :
                </p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check1" id="check1">
                    <label class="form-label-lg fs-6" for="check1">
                        de m’inscrire et de participer aux diverses animations proposées par la structure selon
                        les conditions prévues pour chacune d’entre elles,
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check2" id="check2">
                    <label class="form-label-lg fs-6" for="check2">
                        d’être couvert dans le cadre de l’inscription et de la pratique de ces animations, par le
                        contrat
                        d’assurances souscrit par la structure auprès de la M.A.E., dans la limite des garanties prévues
                        et
                        qui
                        ne me dispensent nullement d’être parallèlement assuré par une Mutuelle Scolaire/Etudiante ou en
                        Responsabilité Civile Individuelle/Familiale,
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="check3" id="check3">
                    <label class="form-label-lg fs-6" for="check3">
                        de participer en tant que membre du collectif des usagers de l’EVS.
                    </label>
                </div>

                <p>Enfin,</p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check4" id="check4">
                    <label class="form-label-lg fs-6" for="check4">
                        je certifie être apte à la pratique des animations auxquelles je choisis de m’inscrire (un
                        certicat
                        médical d’aptitude sera demandé à chaque membre pour les activités à caractère sportif),
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check5" id="check5">
                    <label class="form-label-lg fs-6" for="check5">
                        je décharge les organisateurs de toute responsabilité en cas d’accident survenu avant mon
                        arrivée
                        aux
                        activités pour lesquelles je suis inscrit ou après mon départ de ces activités,
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check6" id="check6">
                    <label class="form-label-lg fs-6" for="check6">
                        j’autorise les organisateurs à prendre toute mesure nécessaire en cas d’urgence médicale,
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check7" id="check7">
                    <label class="form-label-lg fs-6" for="check7">
                        j’autorise l’Espace De Vie Sociale Maison Prévert Francas à consulter mon quotient familial,
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check8" id="check8">
                    <label class="form-label-lg fs-6" for="check8">
                        j’autorise l’EVS à reproduire et à diffuser nos photographies réalisées dans le cadre de ses
                        actions
                        sans porter atteinte à notre réputation ou à notre vie privée.
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check9" id="check9">
                    <label class="form-label-lg fs-6" for="check9">
                        Vous validez l’exactitude des informations saisies dans ce formulaire.
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="check10" id="check10">
                    <label class="form-label-lg fs-6" for="check10">
                        Je décare avoir pris connaissance des modalités de fonctionnement de l’Espace De Vie Sociale
                        Maison
                        Prévert Francas et activités organisées.
                    </label>
                </div>

                <input class="btn btn-success text-uppercase" type="submit" name="" value="Envoyer">
            </div>
        </form>

        <hr>

        <form action="userSpace" method="post">
            <div class="container p-4">
                <input class="btn btn-danger text-uppercase" type="submit" name="" value="Suppression">
                <div class="row">
                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="astname">Nom</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre nom" type="text" name="lastname" id="lastname" value="<?= !empty($resultQuery->getLastname()) ? htmlspecialchars($resultQuery->getLastname()) : '' ?>">
                        <p class="text-danger m-0"><?= isset($infoMessages['lastname']) && !empty($infoMessages['lastname']) ? htmlspecialchars($infoMessages['lastname']) : '' ?></p>
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="firstname">Prénom</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre prénom" type="text" name="firstname" id="firstname" value="<?= !empty($resultQuery->getFirstname()) ? htmlspecialchars($resultQuery->getFirstname()) : '' ?>">
                        <p class="text-danger m-0"><?= isset($infoMessages['firstname']) && !empty($infoMessages['firstname']) ? htmlspecialchars($infoMessages['firstname']) : '' ?></p>
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="mail">Adresse mail</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre émail" type="email" name="mail" id="mail" value="<?= !empty($resultQuery->getEmail()) ? htmlspecialchars($resultQuery->getEmail()) : '' ?>">
                        <p class="text-danger m-0"><?= isset($infoMessages['mail']) && !empty($infoMessages['mail']) ? htmlspecialchars($infoMessages['mail']) : '' ?></p>
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="phone">Téléphone</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre numéro de téléphone" type="tel" name="phone" id="phone" value="<?= !empty($resultQuery->getPhone()) ? htmlspecialchars($resultQuery->getPhone()) : '' ?>">
                        <p class="text-danger m-0"><?= isset($infoMessages['phone']) && !empty($infoMessages['phone']) ? htmlspecialchars($infoMessages['phone']) : '' ?></p>
                    </div>

                    <div class="col-sm-10 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="passw">Modification du mot de passe</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre mot de passe" type="password" name="passw" id="passw">
                        <p class="text-danger m-0"><?= isset($infoMessages['passw']) && !empty($infoMessages['passw']) ? nl2br(htmlspecialchars($infoMessages['passw'])) : '' ?></p>
                    </div>

                    <div class="col-sm-10 col-xl-6 mt-3">
                        <label class="form-label-lg fs-6" for="confPassw">Confirmation mot de passe</label>
                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Confirmez votre mot de passe" type="password" name="confPassw" id="confPassw">
                        <p class="text-danger m-0"><?= isset($infoMessages['confPassw']) && !empty($infoMessages['confPassw']) ? htmlspecialchars($infoMessages['confPassw']) : '' ?></p>
                    </div>
                </div>
                <div>
                    <div>
                        <input class="btn btn-secondary text-uppercase" type="button" name="" value="Annulation">
                        <input class="btn btn-warning text-uppercase" type="submit" name="userUpdate" value="Modification">
                    </div>
                </div>
            </div>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    </section>

    <div class="border py-3 mb-lg-5">
        <h2 class="text-center">Espace documents éducatifs</h2>
    </div>

    <section>
        <form action="">
            <div class="container p-4">
                <div class="row">
                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="nameSchool">Nom de l'école</label>
                        <input class="form-control form-control-lg my-2" type="text" name="nameSchool" id="nameSchool">
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="schoolSelect">Choix de l'école</label>
                        <select class="form-select form-select-lg my-2 fs-6" name="school" id="schoolSelect">
                            <option value="">Ecole</option>
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <label for="">Document à transmettre</label>
                <input class="form-control form-control-lg my-2" type="file" name="" value="Charger">
                <input class="btn btn-success text-uppercase" type="submit" name="" value="Création">
                <p>Liste des documents que vous avez transmis</p>

                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Date</th>
                            <th>Suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tbody>
                </table>
            </div>
        </form>
    </section>

    <section>
        <div class="border py-3 mb-lg-5">
            <h2 class="text-center">Espace réservation</h2>
        </div>

        <article>

        </article>
    </section>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
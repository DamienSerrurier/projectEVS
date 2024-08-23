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
        <div class="colorLine box py-3 mb-lg-5">
            <h2 class="text-center">Espace utilisateur</h2>
        </div>

        <form action="userSpace" method="post" id="form">
            <div class="container p-4">
                <?php
                if (isset($_SESSION['success'])) :
                ?>
                    <p class="text-success"><?= $_SESSION['success'] ?></p>
                <?php
                    unset($_SESSION['success']);
                endif;
                ?>

                <?php
                if (isset($_SESSION['warning'])) :
                ?>
                    <p class="text-warning"><?= $_SESSION['warning'] ?></p>
                <?php
                    unset($_SESSION['warning']);
                endif;
                ?>

                <p class="text-info" id="info"></p>

                <div class="form-check">

                    <input class="form-check-input" type="checkbox" name="member" id="member">
                    <label class="form-label-lg fs-6" for="member">J'adhère à l'association EVS Maison Prévert</label>
                </div>

                <div class="row justify-content-between">
                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="responsibleSelect">Nombre de responsable</label>
                        <select class="form-select form-select-lg my-2 fs-6" name="responsible" id="responsibleSelect">
                            <option value="0">responsable</option>
                            <?php
                            $maxNumberResponsible = 2;
                            for ($i = 1; $i <= $maxNumberResponsible; $i++) :
                                $selected = '';
                                if (isset($_SESSION['responsible']) && $_SESSION['responsible'] == $i) :
                                    $selected = 'selected';
                                endif;
                            ?>
                                <option value="<?= $i ?>" <?= $selected ?>><?= $i ?> responsable</option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>

                    <div class="col-sm-10 col-md-4 col-xl-2">
                        <div class="box rounded
                        text-center">
                            <p>Cotisation annuelle:</p>
                            <ul>
                                <li>5/Adulte</li>
                                <li>2/Mineur</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="memberResponsible">
                    <?php

                    if (isset($_SESSION['responsible']) && $_SESSION['responsible'] > 0) :

                        for ($i = 1; $i <= $_SESSION['responsible']; $i++) :
                    ?>
                            <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['id']) && !empty($arrayInfoMessages[$i]['id']) ? htmlspecialchars($arrayInfoMessages[$i]['id']) : '' ?></p>
                            <fieldset class="box rounded p-4 mt-5" form="">
                                <legend class="col-form-label-lg">Informations personnelles</legend>
                                <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberCivility' . $i]) && !empty($arrayInfoMessages[$i]['memberCivility' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberCivility' . $i]) : '' ?></p>

                                <?php
                                if (!empty($resultCivility)) :

                                    foreach ($resultCivility as $value) :
                                        $checked = '';
                                        if (isset($arrayParametters[$i]['memberCivility' . $i]) && $arrayParametters[$i]['memberCivility' . $i] == $value->getId()) :
                                            $checked = 'checked';
                                        endif
                                ?>
                                        <input class="form-check-input choice" type="radio" name="memberCivility<?= $i ?>" id="choice <?= htmlspecialchars($value->getId()) . $i ?>" value="<?= htmlspecialchars($value->getId()) ?>" <?= $checked ?>>
                                        <label class="form-label-lg fs-6" for="choice <?= htmlspecialchars($value->getId()) . $i ?>"><?= htmlspecialchars($value->getName()) ?></label>
                                <?php
                                    endforeach;
                                endif;
                                ?>

                                <div class="row">
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberLastname<?= $i ?>">Nom</label>
                                        <?php
                                        if (!isset($_POST['createMember']) && $i === 1) :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom" type="text" name="memberLastname<?= $i ?>" id="memberLastname<?= $i ?>" value="<?= !empty($resultQuery->getLastname()) ? htmlspecialchars($resultQuery->getLastname()) : '' ?>">
                                        <?php
                                        else :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom" type="text" name="memberLastname<?= $i ?>" id="memberLastname<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberLastname' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberLastname' . $i]) : '' ?>">
                                        <?php
                                        endif;
                                        ?>
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberLastname' . $i]) && !empty($arrayInfoMessages[$i]['memberLastname' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberLastname' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberFirstname<?= $i ?>">Prénom</label>
                                        <?php
                                        if (!isset($_POST['createMember']) && $i === 1) :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un prénom" type="text" name="memberFirstname<?= $i ?>" id="memberFirstname<?= $i ?>" value="<?= !empty($resultQuery->getFirstname()) ? htmlspecialchars($resultQuery->getFirstname()) : '' ?>">
                                        <?php
                                        else :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un prénom" type="text" name="memberFirstname<?= $i ?>" id="memberFirstname<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberFirstname' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberFirstname' . $i]) : '' ?>">
                                        <?php
                                        endif;
                                        ?>
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberFirstname' . $i]) && !empty($arrayInfoMessages[$i]['memberFirstname' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberFirstname' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberMail<?= $i ?>">Adresse mail</label>
                                        <?php
                                        if (!isset($_POST['createMember']) && $i === 1) :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un émail" type="email" name="memberMail<?= $i ?>" id="memberMail<?= $i ?>" value="<?= !empty($resultQuery->getEmail()) ? htmlspecialchars($resultQuery->getEmail()) : '' ?>">
                                        <?php
                                        else :
                                        ?>
                                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un émail" type="email" name="memberMail<?= $i ?>" id="memberMail<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberMail' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberMail' . $i]) : '' ?>">
                                        <?php
                                        endif;
                                        ?>
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberMail' . $i]) && !empty($arrayInfoMessages[$i]['memberMail' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberMail' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberPhone<?= $i ?>">Téléphone</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de téléphone" type="tel" name="memberPhone<?= $i ?>" id="memberPhone<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberPhone' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberPhone' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberPhone' . $i]) && !empty($arrayInfoMessages[$i]['memberPhone' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberPhone' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberBirthdate<?= $i ?>">Date de naissance</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez une date de naissance" type="date" name="memberBirthdate<?= $i ?>" id="memberBirthdate<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberBirthdate' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberBirthdate' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberBirthdate' . $i]) && !empty($arrayInfoMessages[$i]['memberBirthdate' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberBirthdate' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberBirthPlace<?= $i ?>">Lieu de naissance</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom" type="text" name="memberBirthPlace<?= $i ?>" id="memberBirthPlace<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberBirthPlace' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberBirthPlace' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberBirthPlace' . $i]) && !empty($arrayInfoMessages[$i]['memberBirthPlace' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberBirthPlace' . $i]) : '' ?></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="box rounded p-4 mt-5" form="">
                                <legend class="col-form-label-lg">Informations habitation</legend>

                                <div class="row justify-content-end">
                                    <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                                        <label class="form-label-lg fs-6" for="memberStreetNumber<?= $i ?>">Numéro de rue</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de rue" type="text" name="memberStreetNumber<?= $i ?>" id="memberStreetNumber<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberStreetNumber' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberStreetNumber' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberStreetNumber' . $i]) && !empty($arrayInfoMessages[$i]['memberStreetNumber' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberStreetNumber' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-9 mt-3">
                                        <label class="form-label-lg fs-6" for="memberStreetName<?= $i ?>">Nom de rue</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom de rue" type="text" name="memberStreetName<?= $i ?>" id="memberStreetName<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberStreetName' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberStreetName' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberStreetName' . $i]) && !empty($arrayInfoMessages[$i]['memberStreetName' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberStreetName' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="memberStreetComplement<?= $i ?>">Complément d'adresse</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un complément d'adresse" type="text" name="memberStreetComplement<?= $i ?>" id="memberStreetComplement<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberStreetComplement' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberStreetComplement' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberStreetComplement' . $i]) && !empty($arrayInfoMessages[$i]['memberStreetComplement' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberStreetComplement' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                                        <label class="form-label-lg fs-6" for="memberZipCode<?= $i ?>">Code postal</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un code postal" type="text" name="memberZipCode<?= $i ?>" id="memberZipCode<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberZipCode' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberZipCode' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberZipCode' . $i]) && !empty($arrayInfoMessages[$i]['memberZipCode' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberZipCode' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                                        <label class="form-label-lg fs-6" for="memberCity<?= $i ?>">Ville</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez une ville" type="text" name="memberCity<?= $i ?>" id="memberCity<?= $i ?>" value="<?= isset($arrayParametters[$i]['memberCity' . $i]) ? htmlspecialchars($arrayParametters[$i]['memberCity' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['memberCity' . $i]) && !empty($arrayInfoMessages[$i]['memberCity' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['memberCity' . $i]) : '' ?></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="box rounded p-4 mt-5 mb-2" form="">
                                <legend class="col-form-label-lg">Informations de situation</legend>

                                <div class="row">
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="profession<?= $i ?>">Profession</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="Une profession" type="text" name="profession<?= $i ?>" id="profession<?= $i ?>" value="<?= isset($arrayParametters[$i]['profession' . $i]) ? htmlspecialchars($arrayParametters[$i]['profession' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['profession' . $i]) && !empty($arrayInfoMessages[$i]['profession' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['profession' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="familySituation<?= $i ?>">Situation de famille</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="une situation de famille" type="text" name="familySituation<?= $i ?>" id="familySituation<?= $i ?>" value="<?= isset($arrayParametters[$i]['familySituation' . $i]) ? htmlspecialchars($arrayParametters[$i]['familySituation' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['familySituation' . $i]) && !empty($arrayInfoMessages[$i]['familySituation' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['familySituation' . $i]) : '' ?></p>
                                    </div>
                                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                                        <label class="form-label-lg fs-6" for="cafNumber<?= $i ?>">Numéro d'identifiant d'allocation familiale</label>
                                        <input class="form-control form-control-lg my-2" placeholder="" aria-label="un numéro d'identifiant d'allocation familiale" type="text" name="cafNumber<?= $i ?>" id="cafNumber<?= $i ?>" value="<?= isset($arrayParametters[$i]['cafNumber' . $i]) ? htmlspecialchars($arrayParametters[$i]['cafNumber' . $i]) : '' ?>">
                                        <p class="text-danger m-0"><?= isset($arrayInfoMessages[$i]['cafNumber' . $i]) && !empty($arrayInfoMessages[$i]['cafNumber' . $i]) ? htmlspecialchars($arrayInfoMessages[$i]['cafNumber' . $i]) : '' ?></p>
                                    </div>
                                </div>
                            </fieldset>
                    <?php
                        endfor;
                    endif;
                    ?>
                </div>

                <div class="row">
                    <div class="col-sm-10 col-md-4 col-xl-3">
                        <label class="form-label-lg fs-6" for="minorSelect">Nombre de mineurs</label>
                        <select class="form-select form-select-lg my-2 fs-6" name="minor" id="minorSelect">
                            <option value="">mineur</option>
                            <option value="minor1">1 mineur</option>
                            <option value="minor2">2 mineurs</option>
                        </select>
                    </div>
                </div>

                <fieldset class="box rounded p-4 mt-3 mb-5">
                    <div class="row">
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childLastname">Nom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom d'enfant" type="text" name="childLastname" id="childLastname">
                            <p class="text-danger m-0"><?= isset($infoMessages['childLastname']) && !empty($infoMessages['childLastname']) ? htmlspecialchars($infoMessages['childLastname']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childFirstname">Prénom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un prénom d'enfant" type="text" name="childFirstname" id="childFirstname">
                            <p class="text-danger m-0"><?= isset($infoMessages['childFirstname']) && !empty($infoMessages['childFirstname']) ? htmlspecialchars($infoMessages['childFirstname']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                            <label class="form-label-lg fs-6" for="childBirthdate">Date de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez la date de naissance d'un enfant" type="date" name="childBirthdate" id="childBirthdate">
                            <p class="text-danger m-0"><?= isset($infoMessages['childBirthdate']) && !empty($infoMessages['childBirthdate']) ? htmlspecialchars($infoMessages['childBirthdate']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                            <label class="form-label-lg fs-6" for="childBirthPlace">Lieu de naissance</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un lieu de naissance d'un enfant" type="text" name="childBirthPlace" id="childBirthPlace">
                            <p class="text-danger m-0"><?= isset($infoMessages['childBirthPlace']) && !empty($infoMessages['childBirthPlace']) ? htmlspecialchars($infoMessages['childBirthPlace']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                            <label class="form-label-lg fs-6" for="childPhone">Téléphone</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un numéro de téléphone d'un enfant" type="tel" name="childPhone" id="childPhone">
                            <p class="text-danger m-0"><?= isset($infoMessages['childPhone']) && !empty($infoMessages['childPhone']) ? htmlspecialchars($infoMessages['childPhone']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childSchool">Etablissement scolaire</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom d'école de l'enfant" type="text" name="childSchool" id="childSchool">
                            <p class="text-danger m-0"><?= isset($infoMessages['childSchool']) && !empty($infoMessages['childSchool']) ? htmlspecialchars($infoMessages['childSchool']) : '' ?></p>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="childSchoolCity">Ville de l'établissement scolaire</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez un nom d'école de l'enfant" type="text" name="childSchoolCity" id="childSchoolCity">
                            <p class="text-danger m-0"><?= isset($infoMessages['childSchoolCity']) && !empty($infoMessages['childSchoolCity']) ? htmlspecialchars($infoMessages['childSchoolCity']) : '' ?></p>
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

                <input type="hidden" name="token1" value="<?= $_SESSION['token1'] ?>">
                <input class="btn btn-success text-uppercase" type="submit" name="createMember" id="createMember" value="Envoyer">
            </div>
        </form>
    </section>

    <hr>

    <section>
        <form action="userSpace" method="post">
            <div class="container p-4">
                <input class="btn btn-danger text-uppercase" type="submit" name="deleteUser" value="Suppression">
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
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <input class="btn btn-secondary text-uppercase" type="button" name="" value="Annulation">
                        <input class="btn btn-warning text-uppercase" type="submit" name="updateUser" value="Modification">
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="colorLine box py-3 mb-lg-5">
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
        <div class="colorLine box py-3 mb-lg-5">
            <h2 class="text-center">Espace réservation</h2>
        </div>

        <article>

        </article>
    </section>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/ajax.js"></script>
    <script src="../assets/js/userSpaceResponsible.js"></script>

</body>

</html>
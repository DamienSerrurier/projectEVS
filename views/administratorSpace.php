<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Espace de Vie Social - Espace administrateur</title>
</head>

<body>
    <?php
    require_once 'partials/navbar.php';
    ?>

    <div class="border py-3 mb-lg-5">
        <h2 class="text-center">Espace administrateur</h2>
    </div>

    <ul>
        <li>Gestion des données personnelles</li>
        <li>Gestion des rôle</li>
        <li>Gestion des catégories activités</li>
        <li>Gestion des activités</li>
        <li>Gestion des type de structure</li>
        <li>Gestion des structures</li>
        <li>Gestion des utilisateurs</li>
    </ul>

    <label class="form-label" for="managementSelect">Faites un choix de gestion</label>
    <select class="form-select form-select-lg" name="management" id="managementSelect">
        <option value="">Choix gestion administrateur</option>
        <option value="1">Gestion des données personnelles</option>
        <option value="2">Gestion des rôle</option>
        <option value="3">Gestion des catégories activités</option>
        <option value="4">Gestion des activités</option>
        <option value="5">Gestion des type de structure</option>
        <option value="6">Gestion des structures</option>
        <option value="7">Gestion des utilisateurs</option>
    </select>

    <button class="btn btn-secondary text-uppercase">Annulation</button>
    <form action="">
        <input class="btn btn-danger text-uppercase" type="submit" name="" value="Suppression">

        <h3 class="text-center">Gestion des données personnelles</h3>

        <div class="container p-4">
            <div class="row justify-content-center p-0">
                <div class="row col-sm-10 col-md-4 col-xl-6 justify-content-center p-0">
                    <div class="w-75 justify-items-center">
                        <img class="img-fluid" src="" alt="">
                        <div class="row justify-content-center">
                            <input class="col-6 btn btn-danger text-uppercase" type="submit" name="" value="Supprimer l'image">
                            <label class="form-label-lg fs-6" for="avatar">Avatar</label>
                            <input class="form-control form-control-lg my-3" type="file" name="avatar" id="avatar">
                        </div>
                    </div>
                </div>
                <div class="row col-xl-6 justify-content-center p-0">
                    <div class="col-sm-10 col-md-4 col-xl-12 p-0">
                        <div class="text-center mt-3">
                            <label class="col-form-label-lg fs-6" for="lastname">Nom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre Nom" type="text" name="lastname" id="lastname">
                        </div>
                        <div class="text-center mt-3">
                            <label class="col-form-label-lg fs-6" for="firstname">Prénom</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre Prénom" type="text" name="firstname" id="firstname">
                        </div>
                        <div class="text-center mt-3">
                            <label class="col-form-label-lg fs-6" for="mail">Email</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre adresse mail" type="email" name="mail" id="mail">
                        </div>
                        <div class="text-center mt-3">
                            <label class="col-form-label-lg fs-6" for="phone">Téléphone</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre adresse mail" type="tel" name="phone" id="phone">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-10 col-xl-6 mt-3">
                    <label class="form-label-lg fs-6" for="passw">Création du mot de passe</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre mot de passe" type="password" name="passw" id="passw">
                </div>
                <div class="col-sm-10 col-xl-6 mt-3">
                    <label class="form-label-lg fs-6" for="confPassw">Confirmation mot de passe</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Confirmez votre mot de passe" type="password" name="confPassw" id="confPassw">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 col-xl-2 mt-3">
                    <label class="form-label-lg fs-6" for="streetNumber">Numéro de rue</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre numéro de rue" type="text" name="streetNumber" id="streetNumber">
                </div>
                <div class="col-sm-10 col-xl-10 mt-3">
                    <label class="form-label-lg fs-6" for="streetName">Nom de rue</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre nom de rue" type="text" name="streetName" id="streetName">
                </div>
                <div class="col-sm-10 col-xl-7 mt-3">
                    <label class="form-label-lg fs-6" for="streetComplement">Complément d'adresse</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre complément d'adresse" type="text" name="streetComplement" id="streetComplement">
                </div>
                <div class="col-sm-10 col-xl-3 mt-3">
                    <label class="form-label-lg fs-6" for="zipCode">Code postal</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre code postal" type="text" name="zipCode" id="zipCode">
                </div>
                <div class="col-sm-10 col-xl-2 mt-3">
                    <label class="form-label-lg fs-6" for="city">Ville</label>
                    <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre ville" type="text" name="city" id="city">
                </div>
            </div>
        </div>

        <input class="btn btn-warning text-uppercase" type="submit" name="" value="Modification">

        <h3 class="text-center">Gestion des rôles</h3>

        <div class="container p-4">
            <label class="form-label-lg fs-6" for="roleSelect">Choix du rôle pour modification</label>
            <select class="form-select form-select-lg my-2 fs-6" name="role" id="roleSelect">
                <option value="">Choix du rôle</option>
                <option value=""></option>
            </select>
            <label class="form-label-lg fs-6" for="roleName">Nom du rôle</label>
            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Un rôle" type="text" name="roleName" id="roleName">
        </div>

        <h3 class="text-center">Gestion des catégories activités</h3>

        <div class="container p-4">
            <label class="form-label-lg fs-6" for="categorySelect">Choix de la catégorie d'activités pour
                modification</label>
            <select class="form-select form-select-lg my-2 fs-6" name="category" id="categorySelect">
                <option value="">Choix catégorie</option>
                <option value=""></option>
            </select>
            <label class="form-label-lg fs-6" for="categoryName">Nom de la catégorie</label>
            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Une catégorie" type="text" name="categoryName" id="categoryName">
        </div>

        <h3 class="text-center">Gestion des activités</h3>

        <div class="container p-4">
            <div>
                <label class="form-label-lg fs-6" for="searchActivity">Recherche de l'activité</label>
                <input class="form-control form-control-lg my-2" type="search" name="" id="searchActivity">
                <input class="btn btn-secondary text-uppercase" type="submit" name="" value="Recherche">
            </div>

            <label class="form-label-lg fs-6">Clicker pour voir le détail et modifier l'activité</label>
            <article>

            </article>

            <h4>Gestion des activités</h4>

            <div class="row">
                <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                    <label class="form-label-lg fs-6" for="activityTitle">Titre de l'activité</label>
                    <input class="form-control form-control-lg my-2" type="text" name="activityTitle" id="activityTitle">
                </div>
                <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                    <label class="form-label-lg fs-6" for="moreInformations">Information complémentaire. Ex:
                        Lundi/Mardi...</label>
                    <input class="form-control form-control-lg my-2" type="text" name="moreInformations" id="moreInformations">
                </div>
                <div class="col-sm-10 col-md-4 col-xl-4 mt-3">
                    <label class="form-label-lg fs-6" for="categorySelect">Choix de la catégorie</label>
                    <select class="form-select form-select-lg my-2 fs-6" name="category" id="categorySelect">
                        <option value="">Choix catégorie</option>
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="d-xl-flex justify-content-between">
                <div class="flex-column mt-3">
                    <label class="form-label-lg fs-6" for="">Image de l'activité actuelle</label>
                    <div class="card my-2 mb-0" style="width: 12rem;">
                        <img src="..." class="card-img-top" style="width: 12rem;height: 12rem;" alt="...">
                        <input class="btn btn-danger w-auto" type="submit" name="" value="Supprimer l'image">
                    </div>
                </div>
                <div class="row justify-content-start flex-grow-1">
                    <div class="col-sm-10 col-md-4 col-xl-6 mt-3 ms-xl-4">
                        <label class="form-label-lg fs-6" for="activityDescription">Description de
                            l'activité</label>
                        <textarea class="form-control my-2" style="height: 14rem;" name="" id="activityDescription" cols="30" rows="5"></textarea>
                    </div>
                    <div class="col-sm-10 col-md-4 col-xl-3 mt-3 align-self-end">
                        <label class="form-label-lg fs-6" for="startDate">Date du début</label>
                        <input class="form-control form-control-lg my-2" type="date" name="" id="startDate">

                        <label class="form-label-lg fs-6" for="endDate">Date de fin</label>
                        <input class="form-control form-control-lg my-2" type="date" name="" id="endDate">
                    </div>
                    <div class="col-sm-10 col-md-4 col-xl-2 mt-3 flex-grow-1 align-self-end">
                        <label class="form-label-lg fs-6" for="startHour">Heure du début</label>
                        <input class="form-control form-control-lg my-2" type="time" name="" id="startHour">

                        <label class="form-label-lg fs-6" for="endHour">Heure de fin</label>
                        <input class="form-control form-control-lg my-2" type="time" name="" id="endHour">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10 col-md-4 col-xl-5 mt-3">
                    <label class="form-label-lg fs-6" for="activityPicture">Image de l'activité</label>
                    <input class="col-sm-10 col-md-4 col-xl-4 form-control form-control-lg my-2" type="file" name="activityPicture" id="activityPicture">
                    <input class="btn btn-success" type="submit" name="" value="Charger l'image">
                </div>

            </div>

            <h4>Liste des utilisateurs ayant réservé cette activité</h4>

            <ul>
                <li></li>
            </ul>
        </div>

        <h3 class="text-center">Gestion des type de structure</h3>

        <div class="container p-4">
            <label class="form-label-lg fs-6" for="typeStructureSelect">Choix du type de structure pour
                modification</label>
            <select class="form-select form-select-lg my-2 fs-6" name="typeStructure" id="typeStructureSelect">
                <option value="">Choix de la structure</option>
                <option value=""></option>
            </select>
            <label class="form-label-lg fs-6" for="typeStructureName">Nom du type de structure</label>
            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Une catégorie" type="text" name="typeStructureName" id="typeStructureName">
        </div>

        <h3 class="text-center">Gestion des structures</h3>

        <div class="container p-4">
            <div class="d-xl-flex">
                <div class="flex-column flex-grow-1 mt-3">
                    <label class="form-label-lg fs-6" for="">Logo actuelle</label>
                    <div class="card my-2 mb-0" style="width: 12rem;">
                        <img src="..." class="card-img-top" style="width: 12rem;height: 12rem;" alt="...">
                        <input class="btn btn-danger w-auto" type="submit" name="" value="Supprimer l'image">
                    </div>
                    <div class="row m-0">
                        <label class="form-label-lg fs-6" for="structureLogo">Logo de la structure</label>
                        <input class="col-sm-10 col-md-4 col-xl-4 form-control form-control-lg my-2" type="file" name="structureLogo" id="structureLogo">
                        <input class="btn btn-success" type="submit" name="" value="Charger l'image">
                    </div>
                </div>
                <div>
                    <div class="row justify-content-between">
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="categorySelect">Choix de la structure pour
                                modification</label>
                            <select class="form-select form-select-lg my-2 fs-6" name="category" id="categorySelect">
                                <option value="">Structure</option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="categorySelect">Choix du type de structure</label>
                            <select class="form-select form-select-lg my-2 fs-6" name="category" id="categorySelect">
                                <option value="">Type de structure</option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="structureName">Nom de la structure</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre Nom" type="text" name="structureName" id="structureName">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="structurePhone">Téléphone</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Renseignez votre adresse mail" type="tel" name="structurePhone" id="structurePhone">
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                            <label class="form-label-lg fs-6" for="structureStreetNumber">Numéro de rue</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre numéro de rue" type="text" name="structureStreetNumber" id="structureStreetNumber">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-9 mt-3">
                            <label class="form-label-lg fs-6" for="structureStreetName">Nom de rue</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre nom de rue" type="text" name="structureStreetName" id="structureStreetName">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-6 mt-3">
                            <label class="form-label-lg fs-6" for="structureStreetComplement">Complément
                                d'adresse</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre complément d'adresse" type="text" name="structureStreetComplement" id="structureStreetComplement">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-3 mt-3">
                            <label class="form-label-lg fs-6" for="structureZipCode">Code postal</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre code postal" type="text" name="structureZipCode" id="structureZipCode">
                        </div>
                        <div class="col-sm-10 col-md-4 col-xl-2 mt-3">
                            <label class="form-label-lg fs-6" for="structureCity">Ville</label>
                            <input class="form-control form-control-lg my-2" placeholder="" aria-label="Votre ville" type="text" name="structureCity" id="structureCity">
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-center">Gestion des utilisateurs</h3>

            <label for="searchUser">Recherche d'un utilisateur'</label>
            <input type="search" name="" id="searchUser">

            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Suppression</th>
                    </tr>
                </thead>

                <tbody>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tbody>
            </table>

            <input class="btn btn-success" type="submit" name="" value="Création">

            <input class="btn btn-warning" type="submit" name="" value="Modification">


    </form>

    <?php
    require_once 'partials/footer.html';
    ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
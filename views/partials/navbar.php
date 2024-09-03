<header>
  <div class="d-none d-xl-block">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../../assets/img/iconCoffee.jpg" alt="" width="40rem" height="50rem"></a>
        <div class="row w-100">
          <ul class="navbar-nav justify-content-between">
            <div>
              <li class="">
                <a class="nav-link active" aria-current="page" href="home">Accueil</a>
              </li>
            </div>
            <div class="row">
              <?php
              if (isset($_SESSION['user'])) :
              ?>
                <li class="nav-item col-xl-7">
                  <?php
                  if (isset($_SESSION['user']['name']) && $_SESSION['user']['name'] == "Admin") :
                  ?>
                    <a class="nav-link" href="administratorSpace">Espace admin</a>
                  <?php
                  else :
                  ?>
                    <a class="nav-link" href="userSpace">Espace utilisateur</a>
                </li>
              <?php
                  endif;
              ?>
            <?php
              else :
            ?>
              <li class="nav-item col-xl-7">
                <a class="nav-link" href="accountCreation">Création compte</a>
              </li>
            <?php
              endif;
            ?>
            <?php
            if (isset($_SESSION['user'])) :
            ?>
              <li class="nav-item col-xl-5">
                <a class="nav-link" href="accountLogout">Déconnexion</a>
              </li>
            <?php
            else :
            ?>
              <li class="nav-item col-xl-5">
                <a class="nav-link" href="accountConnection">Connexion</a>
              </li>
            <?php
            endif;
            ?>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <div class="d-xl-none d-sm-block">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home">Accueil</a>
            </li>
            <?php
            if (isset($_SESSION['user'])) :
            ?>
              <li class="nav-item">
                <?php
                if (isset($_SESSION['user']['name']) && $_SESSION['user']['name'] == "Admin") :
                ?>
                  <a class="nav-link" href="administratorSpace">Espace admin</a>
                <?php
                else :
                ?>
                  <a class="nav-link" href="userSpace">Espace utilisateur</a>
              </li>
            <?php
                endif;
            ?>
          <?php
            else :
          ?>
            <li class="nav-item">
              <a class="nav-link" href="accountCreation">Création compte</a>
            </li>
          <?php
            endif;
          ?>
          <?php
          if (isset($_SESSION['user'])) :
          ?>
            <li class="nav-item">
              <a class="nav-link" href="accountLogout">Déconnexion</a>
            </li>
          <?php
          else :
          ?>
            <li class="nav-item">
              <a class="nav-link" href="accountConnection">Connexion</a>
            </li>
          <?php
          endif;
          ?>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>
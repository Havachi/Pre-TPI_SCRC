<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="SCRC, the cool image localization contest website">
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="content\icones\favicon.png" sizes="16x16">

    <link rel="stylesheet" href="content/styles/main.css">
    <link rel="stylesheet" href="content/styles/navbar.css">
    <link rel="stylesheet" href="content/styles/color.css">
    <link rel="stylesheet" href="content/styles/login.css">
    <link rel="stylesheet" href="content/styles/register.css">
    <link rel="stylesheet" href="content/styles/concours.css">
    <link rel="stylesheet" href="content/styles/home.css">
    <link rel="stylesheet" href="content/styles/sidebar.css">
    <link rel="stylesheet" href="content/styles/cards.css">
    <link rel="stylesheet" href="content/styles/leaderboard.css">
    <link rel="stylesheet" href="content/styles/profile.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="content\scripts\theonlyone.js" charset="utf-8"></script>
  </head>
  <body>
    <header>
      <div class="container-nav">
        <div class="navbar">

          <div class="navbar-list">
            <div class="navbar-item home <?=$title=="Acceuil"?"active":""?>">
              <div>
                <a href="index.php?action=home">Accueil</a>
              </div>
            </div>
            <div class="navbar-item concours <?=$title=="Concours"?"active":""?>">
              <div >
                <a href="index.php?action=concours">Concours</a>
              </div>
            </div>
            <div class="navbar-item classement <?=$title=="Classement"?"active":""?>">
              <div>
                <a href="index.php?action=leaderboard">Classement</a>
              </div>
            </div>

            <div class="navbar-item logout <?=($title=="Logout")?"active":""?>">
              <div>
                <?php if (isset($_SESSION['isLogged'])): ?>
                  <a href="index.php?action=logout">Déconnexion</a>
                <?php endif; ?>

              </div>
            </div>

            <div class="navbar-item login last <?=($title=="Login"||$title=="Register")?"active":""?>">
              <div>
                <?php if (isset($_SESSION['isLogged'])): ?>
                  <a href="index.php?action=profile"><?php echo $_SESSION['userFirstName'] ?> <?php echo $_SESSION['userLastName'] ?></a>
                <?php else: ?>
                  <a href="index.php?action=login">Se connecter</a>
                <?php endif; ?>

              </div>

            </div>
          </div>

        </div>
      </div>
      <div class="container-side">
        <button type="button" name="sidebar-icon" class="sidebar-btnCollapse">
          <span class="material-icons md-48 menu-icon">menu</span>
        </button>
          <div class="sidebar">
                <button type="button" class="sidebar-quit "><span class="material-icons md-36">clear</span></button>
                <a href="index.php?action=home">Accueil</a>
                <a href="index.php?action=concours">Concours</a>
                <a href="index.php?action=classement">Classement</a>
                <?php if (isset($_SESSION['isLogged'])): ?>
                  <a href="index.php?action=logout">Déconnexion</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['isLogged'])): ?>
                  <a href="index.php?action=profile"><?php echo $_SESSION['userFirstName'] ?> <?php echo $_SESSION['userLastName'] ?></a>
                <?php else: ?>
                  <a href="index.php?action=login">Se connecter</a>
                <?php endif; ?>
            </div>
      </div>
    </header>
    <div class="container">
      <?php echo $content ?>
    </div>
    <footer>

    </footer>

  </body>

</html>

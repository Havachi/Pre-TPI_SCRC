<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SCRC</title>
    <link rel="stylesheet" href="content/styles/main.css">
    <link rel="stylesheet" href="content/styles/navbar.css">
    <link rel="stylesheet" href="content/styles/color.css">
    <link rel="stylesheet" href="content/styles/login.css">
    <link rel="stylesheet" href="content/styles/register.css">
  </head>
  <body>
    <header>
      <div class="container-nav">
        <div class="navbar">

          <div class="navbar-list">
            <div class="navbar-item home active">
              <div>
                <a href="index.php?action=home">Accueil</a>
              </div>
            </div>
            <div class="navbar-item concours">
              <div >
                <a href="index.php?action=concours">Concours</a>
              </div>
            </div>
            <div class="navbar-item classement">
              <div>
                <a href="index.php?action=classement">Classement</a>
              </div>
            </div>
            <div class="navbar-item login last">
              <div>
                <?php if ($_SESSION['isLogged'] === true): ?>
                  <a href="index.php?action=profile"><?php echo $_SESSION['userFirstName'] ?> <?php echo $_SESSION['userLastName'] ?></a>
                <?php else: ?>
                  <a href="index.php?action=login">Se connecter</a>
                <?php endif; ?>

              </div>
            </div>

          </div>
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

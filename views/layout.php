<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SCRC</title>
    <link rel="stylesheet" href="content/styles/main.css">
    <link rel="stylesheet" href="content/styles/navbar.css">
    <link rel="stylesheet" href="content/styles/color.css">
    <link rel="stylesheet" href="content/styles/login.css">
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
                <a href="index.php?action=login">Se connecter</a>
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

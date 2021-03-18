<?php
$upload_error = null;
if (isset($_SESSION) || !empty($_SESSION)) {
  if (isset($_SESSION['postdata']) || !empty($_SESSION['postdata'])) {
    if (isset($_SESSION['files']) || !empty($_SESSION['files'])) {
      if ($_SERVER['SERVER_NAME']==="localhost") {
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."\\content\\images\\";
      }
      $uploadfile = $uploaddir . $GLOBALS['COUNT_IMAGE']+1 .".". pathinfo($_SESSION['files']['input-image']['name'],PATHINFO_EXTENSION);

      if (move_uploaded_file($_SESSION['files']['input-image']['tmp_name'], $uploadfile)) {
          echo $GLOBALS['UPLOAD_ERROR_MESSAGE'][0];
          echo "Il y a maintenant ". $GLOBALS['COUNT_IMAGE']+1 . " images sur le serveur";
      } else {

          echo "<pre>Le fichier n'as pas pu être téléchargé\r\n";
          echo "Erreur : ". $GLOBALS['UPLOAD_ERROR_MESSAGE'][$_SESSION['files']['input-image']['error']]."</pre>";
      }
    }
  }
}

 ?>

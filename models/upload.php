<?php
require "models/BetterDBConnection.php";
$upload_error = null;
if (isset($_SESSION) || !empty($_SESSION)) {
  if (isset($_SESSION['postdata']) || !empty($_SESSION['postdata'])) {
    if (isset($_SESSION['files']) || !empty($_SESSION['files'])) {
      if ($_SERVER['SERVER_NAME']==="localhost") {
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."\\content\\images\\";
      }
      $uploadfile = $uploaddir . $GLOBALS['COUNT_IMAGE']+1 .".jpg");

      if (move_uploaded_file($_SESSION['files']['input-image']['tmp_name'], $uploadfile)) {
          echo $GLOBALS['UPLOAD_ERROR_MESSAGE'][0];
          echo "Il y a maintenant ". $GLOBALS['COUNT_IMAGE']+1 . " images sur le serveur";
          $imageValues = array("relativePath" => "content/images/".$GLOBALS['COUNT_IMAGE']+1 . ".jpg", "imagePosLat" => $_SESSION['postdata']['inputLat'],"imagePosLon" => $_SESSION['postdata']['inputLon'])
          try {
            $db = new DBConnection;
            $queryUploadImage = $db->query("INSERT INTO images (imageRelativePath, imagePosLat, imagePosLon) VALUES (:relativePath, :imagePosLat, :imagePosLon)",$imageValues);
            if ($queryUploadImage !== 0) {
              $hintsValues = array("imageID" => $GLOBALS['COUNT_IMAGE']+1 , "hint1" => $_SESSION['postdata']['inputHint1'], "hint2" => $_SESSION['postdata']['inputHint2'], "hint3" => $_SESSION['postdata']['inputHint3']);
              $queryUploadImage = $db->query("INSERT INTO hints (imageID, hint1, hint2, hint3) VALUES (:imageID, :hint1, :hint2, :hint3)",$hintsValues);
            }
          } catch (PDOException $e) {

          }



      } else {

          echo "<pre>Le fichier n'as pas pu être téléchargé\r\n";
          echo "Erreur : ". $GLOBALS['UPLOAD_ERROR_MESSAGE'][$_SESSION['files']['input-image']['error']]."</pre>";
          sleep(4);
      }

      header("Location: /index.php?action=admin");
    }
  }
}

 ?>

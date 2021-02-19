<?php
ob_start();
$title = "Concours";
?>

<div class="page-title">
  <h1>Concours</h1>
</div>
<div class="concours-container">
  <div class="concours-currentLevel">
    <span><h3>Photo <?php echo $_SESSION['currentLevel'] ?>/10</h3></span>
  </div>
  <div class="concours-imageContainer">
    <img class="concours-image"src="<?php echo $_SESSION['pathToImage'] ?>" alt="">
  </div>
  <form class="concours-form" action="index.php?action=concours" method="post">

    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLatitude">Latitude (X.xxxxx)</label>
      <input class="concours-formInput" type="text" name="userInputLatitude" value="" required>
    </div>
    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLongitude">Longitude (Y.yyyyy)</label>
      <input class="concours-formInput" type="text" name="userInputLongitude" value="" required>
    </div>

    <div class="concours-tryScores">
      <?php if ($_SESSION['attempsNumber'] == 1): ?>
        <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['tryScores']['Try1'] ?></span>
      <?php elseif($_SESSION['attempsNumber'] == 2): ?>
        <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['tryScores']['Try1'] ?></span>
        <span class="concours-buttonLabel">Tentative 2 : <?php echo $_SESSION['tryScores']['Try2'] ?></span>
      <?php elseif($_SESSION['attempsNumber'] == 3): ?>
        <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['tryScores']['Try1'] ?></span>
        <span class="concours-buttonLabel">Tentative 2 : <?php echo $_SESSION['tryScores']['Try2'] ?></span>
        <span class="concours-buttonLabel">Tentative 3 : <?php echo $_SESSION['tryScores']['Try3'] ?></span>
      <?php endif; ?>
    </div>
    <div class="concours-formGroup">
      <label class="concours-buttonLabel" for="btnTry">Tentative <?php echo $_SESSION['attempsNumber'] ?>/3</label>
      <button class="secondaryButton <?php if ($_SESSION['attempsNumber']>=3){echo 'disabled';} ?>" type="submit" name="btnTry"<?php if ($_SESSION['attempsNumber']>=3){echo 'disabled';} ?>>Vérifier</button>
    </div>
    <div class="concours-formGroup">
      <button class="concours-submitBtn" type="submit" name="btnNext" >Suivant</button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>

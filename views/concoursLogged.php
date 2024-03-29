<?php
ob_start();
$title = "Concours";
if (count($_SESSION['Settings']['Concours']['levelHints']) === 0) {
  cacheControl($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
}

?>

<div class="page-title">
  <h1>Concours</h1>
</div>
<div class="concours-container">



  <div class="card">
    <div class="card-header">
      <div class="concours-currentLevel">
        <span><h3>Photo <?php echo $_SESSION['Settings']['Concours']['currentLevel'] ?>/10</h3></span>
      </div>
    </div>
    <div class="card-sep">
      <hr class="card-separator">
    </div>
<!-- Hints Section Start -->
    <div class="card-textLine concours-hintContainer">

      <?php if ($_SESSION['Settings']['Concours']['hints'] == 3): ?>
        <div class="concours-hintBtnContainer hint0">
          <a class="concours-hintBtn RainBow" href="index.php?action=concours&hint=1">Indice</a>
        </div>
      <?php elseif($_SESSION['Settings']['Concours']['hints'] == 2): ?>
        <div class="concours-hint hint1">
          <div class="concours-hintLabel">
            Indice n° 1/3
          </div>
          <div class="concours-hintText">
            <?php echo($_SESSION['Settings']['Concours']['levelHints'][0]); ?>
          </div>
        </div>
        <div class="concours-hintBtnContainer hint1">
          <a class="concours-hintBtn RainBow" href="index.php?action=concours&hint=2">Indice</a>
        </div>

      <?php elseif($_SESSION['Settings']['Concours']['hints'] == 1): ?>
        <div class="concours-hint hint1">
          <div class="concours-hintLabel">
            Indice n° 1/3
          </div>
          <div class="concours-hintText">
            <?php echo $_SESSION['Settings']['Concours']['levelHints'][0] ?>
          </div>
        </div>
        <div class="concours-hint hint2">
          <div class="concours-hintLabel">
            Indice n° 2/3
          </div>
          <div class="concours-hintText">
            <?php echo $_SESSION['Settings']['Concours']['levelHints'][1] ?>
          </div>
        </div>
        <div class="concours-hintBtnContainer hint2">
          <a class="concours-hintBtn RainBow" href="index.php?action=concours&hint=3">Indice</a>
        </div>

      <?php elseif($_SESSION['Settings']['Concours']['hints'] == 0): ?>
        <div class="concours-hint hint1">
          <div class="concours-hintLabel">
            Indice n° 1/3
          </div>
          <div class="concours-hintText">
            <?php echo $_SESSION['Settings']['Concours']['levelHints'][0] ?>
          </div>
        </div>
        <div class="concours-hint hint2">
          <div class="concours-hintLabel">
            Indice n° 2/3
          </div>
          <div class="concours-hintText">
            <?php echo $_SESSION['Settings']['Concours']['levelHints'][1] ?>
          </div>
        </div>
        <div class="concours-hint hint3">
          <div class="concours-hintLabel">
            Indice n° 3/3
          </div>
          <div class="concours-hintText">
            <?php echo $_SESSION['Settings']['Concours']['levelHints'][2] ?>
          </div>
        </div>
      <?php endif; ?>


    </div>
<!-- Hints Section End -->
    <div class="concours-imageContainer">
      <img class="concours-image"src="<?php echo $_SESSION['Settings']['Concours']['pathToImage'] ?>" alt="">
    </div>
  </div>

  <form class="concours-form" action="index.php?action=concours" method="post">

    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLatitude">Latitude (X.xxxxx)</label>
      <input class="concours-formInput" type="number" min="-180" max="180" step="0.00000001" name="userInputLatitude" value="" <?php if ($_SESSION['Settings']['Concours']['attemptsNumber']<1){echo "required";} ?>>


    </div>
    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLongitude">Longitude (Y.yyyyy)</label>
      <input class="concours-formInput" type="number" min="-180" max="180" step="0.00000001" name="userInputLongitude" value=""  <?php if ($_SESSION['Settings']['Concours']['attemptsNumber']<1){echo "required";} ?>>
    </div>
      <?php if ($_SESSION['Settings']['Concours']['attemptsNumber'] == 0): ?>

      <?php elseif ($_SESSION['Settings']['Concours']['attemptsNumber'] == 1): ?>
        <div class="concours-tryScores">
          <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try1'] ?></span>
        </div>

      <?php elseif($_SESSION['Settings']['Concours']['attemptsNumber'] == 2): ?>
        <div class="concours-tryScores">
          <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try1'] ?></span>
          <span class="concours-buttonLabel">Tentative 2 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try2'] ?></span>
        </div>
      <?php elseif($_SESSION['Settings']['Concours']['attemptsNumber'] == 3): ?>
        <div class="concours-tryScores">
          <span class="concours-buttonLabel">Tentative 1 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try1'] ?></span>
          <span class="concours-buttonLabel">Tentative 2 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try2'] ?></span>
          <span class="concours-buttonLabel">Tentative 3 : <?php echo $_SESSION['Settings']['Concours']['tryScores']['Try3'] ?></span>
        </div>
      <?php endif; ?>
    <div class="concours-formGroup">
      <label class="concours-buttonLabel" for="btnTry">Tentative <?php echo $_SESSION['Settings']['Concours']['attemptsNumber'] ?>/3</label>
      <button class="secondaryButton <?php if ($_SESSION['Settings']['Concours']['attemptsNumber']>=3){echo 'disabled';} ?>" type="submit" name="submitType" value="try" <?php if ($_SESSION['Settings']['Concours']['attemptsNumber']>=3){echo 'disabled';} ?>>Vérifier</button>
    </div>
    <div class="concours-formGroup">
      <button class="concours-submitBtn" type="submit" name="submitType" value="validate">Suivant</button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>

<?php
ob_start();
$title = "Profile";
require "models/gravatar.php";
?>
<div class="page-title">
  <h1>Profile</h1>
</div>
<div class="profile-container">
  <div class="profile-fieldgroup primary card">
    <div class="profile-picture">
      <img class="profile-gravatar" src="<?php echo get_gravatar($_SESSION['userEmailAddress']); ?>" alt="">
    </div>
    <div class="profile-FullName">
      <?php echo $_SESSION['userFirstName']." ".$_SESSION['userLastName']; ?>
    </div>
    <div class="profile-email">
      <?php echo $_SESSION['userEmailAddress'] ?>
    </div>
  </div>
  <div class="profile-fieldgroup secondary card">
    <div class="profile-bestscore">
      Votre meilleur score:
    </div>
    <div class="profile-PB">
      <?php echo $PB; ?>

    </div>
    <div class="profile-PosLabel">
      Votre classement:
    </div>
    <?php if ($Pos == 1): ?>
      <div class="profile-Pos first">
        <?php echo $Pos."<sup>er</sup>"; ?>
      </div>
    <?php elseif($Pos == 2): ?>
      <div class="profile-Pos second">
        <?php echo $Pos."<sup>ème</sup>"; ?>
      </div>
    <?php elseif($Pos == 3): ?>
      <div class="profile-Pos third">
        <?php echo $Pos."<sup>ème</sup>"; ?>
      </div>
    <?php else: ?>
      <div class="profile-Pos">
        <?php echo $Pos."<sup>ème</sup>"; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="profile-fieldgroup tertiary card">
    <div class="profile-lastGame">
      <div class="profile-lastGame-label">
        Votre dernière partie:
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require "layout.php";
?>

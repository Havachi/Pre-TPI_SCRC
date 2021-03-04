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
      100
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require "layout.php";
?>

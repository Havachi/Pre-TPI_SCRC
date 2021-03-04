<?php
ob_start();
$title = "Classement";
$pos=1;
?>
<div class="page-title">
  <h1>Classement</h1>
</div>

<div class="leaderboard-container">
  <table class="leaderboard-table">
    <tr class="leaderboard-table-headerRow">
      <th>Position</th>
      <th>Prénom</th>
      <th>Nom</th>
      <th>Score</th>
    </tr>
    <?php foreach ($leaderboard as $user): ?>
      <?php if (isset($_SESSION['isLogged'])): ?>
        <?php if ($user['userFirstName'] == $_SESSION['userFirstName'] && $user['userLastName'] == $_SESSION['userLastName'] ): ?>
          <tr class="leaderboard-table-row current">
        <?php else: ?>
          <tr class="leaderboard-table-row ">
        <?php endif; ?>
      <?php else: ?>
        <tr class="leaderboard-table-row ">
      <?php endif; ?>
        <td><?php echo $pos ?></td>
        <?php $pos++; ?>
      <?php foreach ($user as $value): ?>
        <td><?php echo $value ?></td>
      <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>

</table>
</div>
<?php
$content = ob_get_clean();
require "layout.php";
?>

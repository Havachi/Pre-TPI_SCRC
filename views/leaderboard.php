<?php
ob_start();
$title = "Classement";
$leaderboard = array(
  array('position' => '3','userFirstName' => 'jean-paul', 'userLastName' => 'chervet', 'userPBScore' => '2'),
  array('position' => '2','userFirstName' => 'Samuel', 'userLastName' => 'Bryan', 'userPBScore' => '13'),
  array('position' => '1','userFirstName' => 'Paul-Alexandre', 'userLastName' => 'De Gauthier', 'userPBScore' => '50'),
);
?>
<div class="page-title">
  <h1>Classement</h1>
</div>

<div class="leaderboard-container">
  <table class="leaderboard-table">
    <tr class="leaderboard-table-headerRow">
      <th>Position</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Score</th>
    </tr>
    <tr class="leaderboard-table-row">
      <td>1</td>
      <td>test</td>
      <td>test</td>
      <td>100</td>
    </tr>
    <?php foreach ($leaderboard as $user): ?>
      <tr class="leaderboard-table-row">
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

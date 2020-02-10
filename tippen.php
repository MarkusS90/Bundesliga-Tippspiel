<?php
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';
require './src/header.php';
require './src/jumbotron.php';
$db   = new \PDO('mysql:dbname=tippspiel;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);
?>

<div class="row">
  <div class="col-sm-2"><h4>Spieltag</h4>
    <div class="form-group">
    <select class="form-control" id="sel1">
        <?php
for ($i = 1; $i <= 34; $i++) {
    $sel = "";
    if ($i == $_GET['spieltag'])
        $sel = "selected";
    echo "<option $sel >$i</option>";
    $sel = "";
}
?>
   </select>
    </div> 
  </div>
  <div class="col-sm-10">

   <?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.openligadb.de/api/getmatchdata/bl1/2019/" . $_GET['spieltag']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);
curl_close($ch);

echo '<div class="table-responsive"><table class="table">
  <thead>
    <tr>
      <th>Anpiff</th>
      <th>Heim</th>
      <th>Gast</th>
      <th>Ergebnis</th>
      <th>Tipp</th>
      <th>Punkte</th>
    </tr>
  </thead>
  <tbody>';

$matches = json_decode($output, true);
foreach ($matches as $match) {
    if ($match["MatchIsFinished"] == 'true') {
        $ro      = "readonly style='background-color: lightgrey;'";
        $btnsend = '';
    } else {
        $btnsend = '&nbsp;<button class="btn btn-primary" type="submit">💾</button>';
    }
    $statement = $db->prepare("SELECT * FROM tipps WHERE spielid = ? AND userid = ?");
    $statement->execute(array(
        $match["MatchID"],
        $auth->getUserId()
    ));
    $res = $statement->fetch();
    if ($res != false && $res['punkte'] == "" && $match["MatchIsFinished"]) {
        $statement = $db->prepare("UPDATE tipps SET punkte = ? WHERE spielid = ? AND userid = ?");
        
        if ($match["MatchResults"][0]['PointsTeam1'] == $res['tore_1'] && $match["MatchResults"][0]['PointsTeam2'] == $res['tore_2'])
            $statement->execute(array(
                3,
                $match["MatchID"],
                $auth->getUserId()
            ));
        else if (($match["MatchResults"][0]['PointsTeam1'] < $match["MatchResults"][0]['PointsTeam2'] && $res['tore_1'] < $res['tore_2']) || ($match["MatchResults"][0]['PointsTeam1'] > $match["MatchResults"][0]['PointsTeam2'] && $res['tore_1'] > $res['tore_2']) || ($match["MatchResults"][0]['PointsTeam1'] === $match["MatchResults"][0]['PointsTeam2'] && $res['tore_1'] === $res['tore_2']))
            $statement->execute(array(
                1,
                $match["MatchID"],
                $auth->getUserId()
            ));
        else
            echo $statement->execute(array(
                0,
                $match["MatchID"],
                $auth->getUserId()
            ));
    }
    
    echo '<tr>';
    echo '<td>' . date("d.m.Y H:i", strtotime($match["MatchDateTime"])) . '</td>';
    echo '<td>' . $match["Team1"]["TeamName"] . '</td>';
    echo '<td>' . $match["Team2"]["TeamName"] . '</td>';
    echo '<td>' . $match["MatchResults"][0]['PointsTeam1'] . ': ' . $match["MatchResults"][0]['PointsTeam2'] . '</td>';
    echo '<td><form method="POST" action="tippverarbeiten.php?spieltag=' . $_GET['spieltag'] . '"><input type="hidden" name="spielid" value="' . $match["MatchID"] . '" /><input type="number" name="tore1" value="' . $res['tore_1'] . '" ' . $ro . '/><input type="number" name="tore2" value="' . $res['tore_2'] . '" ' . $ro . '/>' . $btnsend . '</form></td>';
    echo '<td>';
    if (isset($res['punkte']))
        echo $res['punkte'] . ' Punkte';
    echo '</td>';
    echo '</tr>';
}

echo '</tbody></table></div>';
?>
 </div>
</div> 

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Auswertung</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php
          $statement = $db->prepare("SELECT SUM(punkte) AS punkte FROM tipps WHERE userid = ?");
          $statement->execute(array(
              $auth->getUserId()
          ));
          $punkte = $statement->fetch();
          ?>
                Gesamtpunktestand: <?php
          echo $punkte['punkte'];
          ?>
     </div>

    </div>
  </div>
</div>

<script>
$('#sel1').change(function() {
    window.location = "tippen.php?spieltag=" + $(this).val();
});
</script>

<?php
require './src/footer.php';
?> 
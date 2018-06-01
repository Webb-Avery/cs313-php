<?php
$zoneId = $_GET["zone"];
$plantId = $_GET["plant"];
echo "<p>$zoneId, $plantId</p>";
$query = 'INSERT INTO zonesPlants(zonesid, plantsid) VALUES(:zonesid, :plantsid)';
$statement = $db->prepare($query);
            
$statement->bindValue(':zonesid', $zoneId);
$statement->bindValue(':plantsid', $plantId);

$statement->execute();

header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
exit;

?>
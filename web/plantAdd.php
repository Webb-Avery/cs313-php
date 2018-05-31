<?php
$zoneId = $_GET["zone"];
$plantId = $_GET["plant"];
$query = 'INSERT INTO zonesPlants(zonesid, plantsid) VALUES(:zonesid, :plantsid)';
$statement = $db->prepare($query);
            
$statement->bindValue(':zonesid', $zoneId);
$statement->bindValue(':plantsid', $plantId);

$statement->execute();

//header("Location: https://sheltered-beyond-43060.herokuapp.com/myGarden.php" );
echo "<p>Test</p>";
?>

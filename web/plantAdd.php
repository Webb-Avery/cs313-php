<html>
<?php
try
{
    $dbUrl = getenv('DATABASE_URL');
    $dbopts = parse_url($dbUrl);
    
    $dbHost = $dbopts["host"];
    $dbPort = $dbopts["port"];
    $dbUser = $dbopts["user"];
    $dbPassword = $dbopts["pass"];
    $dbName = ltrim($dbopts["path"],'/');
    
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}


$zoneId = $_GET["zone"];
$plantId = $_GET["plant"];
$query = 'INSERT INTO zonesPlants(zonesid, plantsid) VALUES(:zonesid, :plantsid)';
$statement = $db->prepare($query);
            
$statement->bindValue(':zonesid', $zoneId);
$statement->bindValue(':plantsid', $plantId);

$statement->execute();

header("Location: https://sheltered-beyond-43060.herokuapp.com/myGarden.php" );

?>

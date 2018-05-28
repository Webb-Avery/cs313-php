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
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="main.css">
    <title>Plants</title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>

    <h1>Plants</h1>



    <table style="width:100%">
    <tr>
        <th>NAME </th>
        <th>Sun exposure </th>
        <th>Water needed per week in inches </th>
        <th>When to plant </th>
        <th>Plant Spread </th>
        <th>Plant height </th>
        <th>Life Cycle </th>
        <th> Plant Type </th>
    </tr>
<?php

$sun = $_GET["sun"];
$sun = 'Full Sun';
$query = "SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype FROM plants";
$statement = $db->prepare($query);
//$statement->bindValue(":sun", $sun, PDO::PARAM_STR);
$statement->execute();

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $plant)
{

    $name = $plant["name"];
    $sun = $plant["sunexposure"];
    $water = $plant["waterinches"];
    $timeToPlant = $plant["timetoplant"];
    $spread = $plant["spread"];
    $height = $plant["height"];
    $lifeCycle = $plant["lifecycle"];
    $type = $plant["planttype"];
    echo"<tr>";
    echo "<td>$name</td>";
    echo "<td>$sun</td>";
    echo "<td>$water</td>";
    echo "<td>$timeToPlant</td>";
    echo "<td>$spread</td>";
    echo "<td>$height</td>";
    echo "<td>$lifeCycle</td>";
    echo "<td>$type</td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>
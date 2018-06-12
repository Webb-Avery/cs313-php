<?php
session_start();

if(!isset($_SESSION["plantId"])){
    $_SESSION["plantId"] = "";
}
if(!isset($_SESSION["zoneId"])){
    $_SESSION["zoneId"] = "";
}
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

    <?php

    echo "<h1>Plants perfect for your zone!</h1>";
    
    echo "<table style='width:90%'><tr>
        <th>NAME </th>
        <th>Sun exposure </th>
        <th>Water needed per week in inches </th>
        <th>When to plant </th>
        <th>Plant Spread </th><th>Plant height </th>
        <th>Life Cycle </th>
        <th> Plant Type </th></tr>";

    $query = "SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype, id FROM plants";

    $sun = $_GET["sun"];
    if($sun != 'none')
    {
        echo "TESTING $sun";
       if($sun == 'fullsun')
       {
            $sun = 'Full Sun';
        }      
        else if($sun == 'partsun')
        {
            $sun = 'Part Sun';
        }
        else if($sun == 'fullshade')
        {
           $sun = 'Full Shade';
        }
        $query .= " WHERE sunexposure = :sun";
        echo "$query";
    }

    $life = $_GET["life"];
    if($life == '')
    {
        $life = 'none';
    }
    if($life != 'none')
    {
        if($life == 'annual')
        {
            $life = "Annual";
        }
        else if($life == 'perennial')
        {
            $life = 'Perennial';
        
        }

        
        if ($sun == "none" && $water == "none")
        {
            $query .= " WHERE lifecycle = :life";
        }
        else {
            $query .= " AND lifecycle = :life";
        }
    }
    
    $water = $_GET["water"];    
    $waterExtra = $water;
    if($water == '')
    {
        $water = 'none';
    }
    if($water != 'none')
    {
        if($water == '1')
        {
            $water = '1 inch';
            $waterExtra = '1-2 inch';
        }
        else if($water == '2')
        {
            $water = '2 inches';
            $waterExtra = '1-2 inch';
        }
    
        if ($sun == "none")
        {
            $query .= " WHERE waterinches = :water OR waterinches = :waterExtra";
        }
        else {
            $query .= " AND waterinches = :water OR waterinches = :waterExtra AND sunexposure = :sun";
        }
    } 
    
    $life = $_GET["life"];
    if($life == '')
    {
        $life = 'none';
    }
    if($life != 'none')
    {
        if($life == 'annual')
        {
            $life = "Annual";
        }
        else if($life == 'perennial')
        {
            $life = 'Perennial';
        
        }

        
        if ($sun == "none" && $water == "none")
        {
            $query .= " WHERE lifecycle = :life";
        }
        elseif(water == "none")
        {
            
        }
        else {
            $query .= " AND lifecycle = :life";
        }
    }

    echo "<br>$query";
    $statement = $db->prepare($query);
    if ($sun != 'none')
    { 
        $statement->bindValue(":sun", $sun, PDO::PARAM_STR);

    }
    if ($water != 'none')
    {
        $statement->bindValue(":water", $water, PDO::PARAM_STR);
        $statement->bindValue(":waterExtra", $waterExtra, PDO::PARAM_STR);
    }
    if ($life != 'none')
    {
    $statement->bindValue(":life", $life, PDO::PARAM_STR);
    }
    $statement->execute();

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $plant)
    {

        $zoneId = $_GET["id"];
        $name = $plant["name"];
        $sun = $plant["sunexposure"];
        $water = $plant["waterinches"];
        $timeToPlant = $plant["timetoplant"];
        $spread = $plant["spread"];
        $height = $plant["height"];
        $lifeCycle = $plant["lifecycle"];
        $type = $plant["planttype"];
        $plantId = $plant["id"];
        echo"<tr>";
        echo "<td>$name</td>";
        echo "<td>$sun</td>";
        echo "<td>$water</td>";
        echo "<td>$timeToPlant</td>";
        echo "<td>$spread</td>";
        echo "<td>$height</td>";
        echo "<td>$lifeCycle</td>";
        echo "<td>$type</td>";
        echo "<td><a href='https://sheltered-beyond-43060.herokuapp.com/plantAdd.php?zone=$zoneId&plant=$plantId'>Add to Zone</a> </td>";
        echo "</tr>";
    }

?>

</table>








<h1> Browse All Plants (These might not be perfect for your zones) </h1>
<table style='width:90%'>
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
foreach ($db->query('SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype, id FROM plants') as $plant)
{

    $name = $plant["name"];
    $sun = $plant["sunexposure"];
    $water = $plant["waterinches"];
    $timeToPlant = $plant["timetoplant"];
    $spread = $plant["spread"];
    $height = $plant["height"];
    $lifeCycle = $plant["lifecycle"];
    $type = $plant["planttype"];
    $plantId = $plant["id"];
    echo"<tr>";
    echo "<td>$name</td>";
    echo "<td>$sun</td>";
    echo "<td>$water</td>";
    echo "<td>$timeToPlant</td>";
    echo "<td>$spread</td>";
    echo "<td>$height</td>";
    echo "<td>$lifeCycle</td>";
    echo "<td>$type</td>";
    echo "<td><a href='https://sheltered-beyond-43060.herokuapp.com/plantAdd.php?zone=$zoneId&plant=$plantId'>Add to Zone</a> </td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>
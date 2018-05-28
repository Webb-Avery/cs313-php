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

<?php
$sun = $_GET["sun"];
if($sun != 'none')
{
    if($sun == 'fullsun')
    {
        echo "<h1>Plants needing full sun: </h1>";
        $sun = 'Full Sun';

    }
    else if($sun == 'partsun')
    {
        echo "<h1>Plants needing part sun: </h1>";
        $sun = 'Part Sun';

    }
    else if($sun == 'fullshade')
    {
        echo "<h1>Plants needing full shade: </h1>";
        $sun = 'Full Shade';

    }
    else 
    {
        echo "<h1> Error </h1>";
    }

    echo "<table style='width:100%'><tr>
        <th>NAME </th>
        <th>Sun exposure </th>
        <th>Water needed per week in inches </th>
        <th>When to plant </th>
        <th>Plant Spread </th><th>Plant height </th>
        <th>Life Cycle </th>
        <th> Plant Type </th></tr>";

    $query = "SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype FROM plants WHERE sunexposure = :sun";
    $statement = $db->prepare($query);
    $statement->bindValue(":sun", $sun, PDO::PARAM_STR);
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
}
?>
</table>


<?php
$water = $_GET["water"];
if($water != 'none')
{
    if($water == '1')
    {
        echo "<h1>Plants needing 1 inch of water: </h1>";
        $water = '1 inch';

    }
    else if($water == '2')
    {
        echo "<h1>Plants needing 2 inches of water: </h1>";
        $water = '2 inches AND waterinches = 1-2 inches ';

    }
    else if($water == '3')
    {
        echo "<h1>Plants needing 3 inches of water: </h1>";
        $water = '3 inches';

    }
    else 
    {
        echo "<h1> Error </h1>";
    }

    echo "<table style='width:100%'><tr>
        <th>NAME </th>
        <th>Sun exposure </th>
        <th>Water needed per week in inches </th>
        <th>When to plant </th>
        <th>Plant Spread </th><th>Plant height </th>
        <th>Life Cycle </th>
        <th> Plant Type </th></tr>";

    $query = "SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype FROM plants WHERE waterinches = :water";
    $statement = $db->prepare($query);
    $statement->bindValue(":water", $water, PDO::PARAM_STR);
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
}
?>
</table>







<h1> The Entire Database, for testing </h1>
<table>
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
foreach ($db->query('SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype FROM plants') as $plant)
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
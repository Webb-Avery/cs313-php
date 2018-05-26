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
</head>
<body>
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
foreach ($db->query('SELECT name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype FROM plants') as $plant)
{

    $name = $plant["name"];
    $sun = $plant["sunExposure"];
    $water = $plant["waterInches"];
    $timeToPlant = $plant["timeToPlant"];
    $spread = $plant["spread"];
    $height = $plant["height"];
    $lifeCycle = $plant["lifeCycle"];
    $type = $plant["plantType"];
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
    </ul>

</body>
</html>
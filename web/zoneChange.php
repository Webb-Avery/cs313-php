<?php
session_start();


if(!isset($_SESSION["login"])){
    $_SESSION["login"] = "";
}

if(!isset($_SESSION["username"])){
    $_SESSION["username"] = "";
}


if(!isset($_SESSION["gardenId"])){
    $_SESSION["gardenId"] = "";
}


if(!isset($_SESSION["username"])){
    $_SESSION["username"] = "";
}

if(!isset($_SESSION["gardenName"])){
    $_SESSION["gardenName"] = "";
}


if(!isset($_SESSION['usernameError'])){
    $_SESSION["usernameError"] = "";
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

$query = "SELECT id, name, sunexposure, waterinches FROM zones WHERE id = :zoneId";
$statement = $db->prepare($query);
$statement->bindValue(":zoneId", $_GET["zone"], PDO::PARAM_STR);
$statement->execute();

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $zone)
{
    $zoneName = $zone["name"];
    $sun = $zone["sunexposure"];
    $water = $zone["waterinches"];
    $id = $zone["id"];
    echo "<h2> Zone: $zoneName</h2>";
}  
?>


<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <header id="top"> 
            <?php include 'nav.php'; ?>
        </header>


<h2> Create a New Zone </h2>
<form method="post" action="myGarden.php">
    <input type="hidden" id="hidden" name="hidden"  value="addZone"></input>
    <label> Zone Name: </label>
    <?php    echo "<input type='text' id='name' name='name' value=$zoneName></input>"; ?>
    <br />
    Sun Exposure <select name="sun">
        <option value="fullsun">Full Sun </option>
        <option value="partsun">Part Sun</option>
        <option value="fullshade">Full Shade</option>
    </select>
            
    <br>
    Water needed <select name="water">
        <option value="1">1 inch per week </option>
        <option value="2">2 inches per week</option>
    </select>
    <br>
    <input class='submit' type="submit" value="Add Zone!">
</form>
<br>
</body>
</html>
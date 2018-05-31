<?php
session_start();


if(!isset($_SESSION["username"])){
    $_SESSION["username"] = "";
}


if(!isset($_SESSION["gardenId"])){
    $_SESSION["gardenId"] = "";
}


if(!isset($_SESSION["gardenName"])){
    $_SESSION["gardenName"] = "";
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
    </head>

    <body>
        <header id="top"> 
            <?php include 'nav.php'; ?>
        </header>

            
        <?php

        $type = $_POST['hidden'];
    
        if($type == 'signup') 
        {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $_SESSION["username"] = $username;
            $password = $_POST['password'];

            try
            {
                $query = 'INSERT INTO users(firstname, lastname, username, password) VALUES(:firstname, :lastname, :username, :password)';
                $statement = $db->prepare($query);
        

                $statement->bindValue(':firstname', $firstname);
                $statement->bindValue(':lastname', $lastname);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':password', $password);
                $statement->execute();

                $userId = $db->lastInsertId("users_id_seq");

                $newQuery = 'INSERT INTO gardens(name, userid) VALUES(:garden, :userId)';
           
                $gardenName = $firstname . '\'s Garden';
                $newStatement = $db->prepare($newQuery); 
                $newStatement->bindValue(':garden', $gardenName);
                $newStatement->bindValue(':userId', $userId);
                $newStatement->execute();

                $gardenId = $db->lastInsertId("gardens_id_seq");


                $_SESSION["gardenName"] = $gardenName;
                $_SESSION["gardenId"] = $gardenId;

            }
            catch (Exception $ex)
            {
                // Please be aware that you don't want to output the Exception message in
                // a production environment
                echo "Error with DB. Details: $ex";
                die();
            }
         
            
        }
        elseif($type == 'login') {
            $username = $_POST['username'];
            $password = $_POST['password'];


                
            $query = "SELECT username, password, id FROM users WHERE username = :username";
            $statement = $db->prepare($query);
            $statement->bindValue(":username", $username, PDO::PARAM_STR);
            $statement->execute();

            foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $user)
            {
        
                $correctPassword = $user["password"];
                if($password == $correctPassword)
                {

                    $userId = $user["id"];
                    $query = "SELECT name, id FROM gardens WHERE userid = :userId ";
                    $statement = $db->prepare($query);
                    $statement->bindValue(":userId", $userId, PDO::PARAM_STR);
                    $statement->execute();
                    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $garden)
                    {
                        $gardenName = $garden["name"];
                        $gardenId = $garden["id"];
                        
                        $_SESSION["gardenName"] = $gardenName;
                        $_SESSION["gardenId"] = $gardenId;

                    }       
                }
                else
                {
                    echo "<p>Login failed</p>";
                }
            }
        }
        elseif($type == 'addZone')
        {
            $gardenName = $_SESSION["gardenName"];

            $name = $_POST['name'];
            $sun = $_POST['sun'];
            $water = $_POST['water'];
            $hardiness = $_POST['hardiness'];

            try
            {
                $query = 'INSERT INTO zones(name, sunexposure, waterinches, hardiness, gardenid) VALUES(:name, :sun, :water, :hardiness, :gardenid)';
                $statement = $db->prepare($query);
        

                $statement->bindValue(':name', $name);
                $statement->bindValue(':sun', $sun);
                $statement->bindValue(':water', $water);
                $statement->bindValue(':hardiness', $hardiness);
                $statement->bindValue(':gardenid', $_SESSION["gardenId"]);
                $statement->execute();

            }
            catch (Exception $ex)
            {
                // Please be aware that you don't want to output the Exception message in
                // a production environment
                echo "Error with DB. Details: $ex";
                die();
            }
        }
        else {

            header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
            

        }

        
        echo "<h1>$gardenName<h1>";

        $query = "SELECT name, sunexposure, waterinches, hardiness FROM zones WHERE gardenId = :gardenId";
        $statement = $db->prepare($query);
        $statement->bindValue(":gardenId", $_SESSION["gardenId"], PDO::PARAM_STR);
        $statement->execute();

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $zone)
        {
            $zoneName = $zone["name"];
            $sun = $zone["sunexposure"];
            $water = $zone["waterinches"];
            $hardiness = $zone["hardiness"];
            echo "<h2> Zone: $zoneName</h2>";
            
        }
        ?>
    
        

        <h1> 
        <h2> Create Zone </h2>
        <form method="post" action="myGarden.php">
            <input type="hidden" id="hidden" name="hidden"  value="addZone"></input>
            <label> Zone Name: </label>
            <input type="text" id="name" name="name"></input>
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


            Hardiness Zone <select name="hardiness">
                <option value="1">Zone 1 </option>
                <option value="2">Zone 2</option>
                <option value="3">Zone 3</option>
                <option value="4">Zone 4</option>
                <option value="5">Zone 5</option>
                <option value="6">Zone 6</option>
                <option value="7">Zone 7</option>
                <option value="8">Zone 8</option>
                <option value="9">Zone 9</option>
                <option value="10">Zone 10</option>
            </select>

            <a target="_blank" href="http://planthardiness.ars.usda.gov/PHZMWeb/">Have no idea what Hardiness Zone you live in? </a><br> <br>
            <input type="submit" value="Add Zone!">
        </form>

        
    </body>
</html>
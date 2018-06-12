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
            $confirmPass = $_POST['passwordConfirm'];

            $regex= "((?=.*\d)(?=.*[a-zA-Z]){7,30})";

            if (!preg_match($regex, $password))
            {
                header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                die();
            }


            if ($password != $confirmPass)
            {
                header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                $_SESSION["usernameError"] = "Passwords did not match. Try again";
                die();
            }

            if ($_SESSION['username'] == '') {
           
                header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                die();
           
            }



            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        

            try
            {
                $statement = $db->prepare('SELECT username FROM users where username = :user');                

                $statement->bindValue(':user', $username);
                $statement->execute();
                while ($row = $statement->fetch())
                {
                    header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                    $_SESSION["usernameError"] = "Username  was already taken. Please try again.";
                    die();
                }
                

            }
            catch (Exception $ex)
            {
                // Please be aware that you don't want to output the Exception message in
                // a production environment
                echo "Error with DB. Details: $ex";
                die();
            }
            

            try
            {
                $query = 'INSERT INTO users(firstname, lastname, username, password) VALUES(:firstname, :lastname, :username, :password)';
                $statement = $db->prepare($query);
        

                $statement->bindValue(':firstname', $firstname);
                $statement->bindValue(':lastname', $lastname);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':password', $passwordHash);
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
                if(password_verify($password, $correctPassword))
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
            $gardenName = $_SESSION["gardenName"];
            

        }

        
        echo "<h1>$gardenName<h1>";

        $query = "SELECT id, name, sunexposure, waterinches FROM zones WHERE gardenId = :gardenId";
        $statement = $db->prepare($query);
        $statement->bindValue(":gardenId", $_SESSION["gardenId"], PDO::PARAM_STR);
        $statement->execute();

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $zone)
        {
            $zoneName = $zone["name"];
            $sun = $zone["sunexposure"];
            $water = $zone["waterinches"];
            $id = $zone["id"];
            echo "<h2> Zone: $zoneName</h2>";


            $query2 = "SELECT plants.name, plants.timetoplant, plants.height, plants.spread, plants.lifecycle, plants.planttype 
                      FROM ((plants INNER JOIN zonesPlants ON plants.id = zonesPlants.plantsid) 
                      INNER JOIN zones ON zonesPlants.zonesid = zones.id) 
                      WHERE zones.id = :zoneId";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":zoneId", $id);
            $statement2->execute();
    
            $first = "true";
            foreach ($statement2->fetchAll(PDO::FETCH_ASSOC) as $plant)
            {
                if ($first == "true")
                {
                    echo "<table style='width:100%'><tr>
                    <th>NAME </th>
                    <th>When to plant </th>
                    <th>Plant Spread </th>
                    <th>Plant height </th>
                    <th>Life Cycle </th>
                    <th> Plant Type </th></tr>";
                    $first = "false";
                }
                
                $name = $plant["name"];
                $timeToPlant = $plant["timetoplant"];
                $spread = $plant["spread"];
                $height = $plant["height"];
                $lifeCycle = $plant["lifecycle"];
                $type = $plant["planttype"];
                echo"<tr>";
                echo "<td>$name</td>";
                echo "<td>$timeToPlant</td>";
                echo "<td>$spread</td>";
                echo "<td>$height</td>";
                echo "<td>$lifeCycle</td>";
                echo "<td>$type</td>";
                echo "</tr>";

            }
            echo "</table>";

            echo "<a href='https://sheltered-beyond-43060.herokuapp.com/plant.php?sun=$sun&water=$water&id=$id'>Add a plant to this Zone</a> <br>";
            
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
            <input type="submit" value="Add Zone!">
        </form>

        
    </body>
</html>
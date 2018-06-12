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
            
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $username = htmlspecialchars($_POST['username']);
            $_SESSION["username"] = $username;
            $password = htmlspecialchars($_POST['password']);
            $confirmPass = htmlspecialchars($_POST['passwordConfirm']);

            $regex= "((?=.*\d)(?=.*[a-zA-Z]){7,30})";

            if (!preg_match($regex, $password))
            {
                $_SESSION["usernameError"] = "Passwords must be at least 8 characters long and contain a number. Try again";
                header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                
                die();
            }


            if ($password != $confirmPass)
            {
                $_SESSION["usernameError"] = "Passwords did not match. Try again";
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
                    $_SESSION["usernameError"] = "Username  was already taken. Please try again.";
                    header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                    
                    die();
                }
                

            }
            catch (Exception $ex)
            {
                // Please be aware that you don't want to output the Exception message in
                // a production environment
                //echo "Error with DB. Details: $ex";
                die();
            }
            

            try
            {
                $_SESSION["login"] = "true";
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
                //echo "Error with DB. Details: $ex";
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

                    

                    $_SESSION["login"] = "true";

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
                    
                    $_SESSION["usernameError"] = "Username and Password did not match.";
                    $_SESSION["login"] = "false";
                    header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
                    
                    die();
                    echo "<p>Login failed</p>";
                }
            }
        }
        elseif($type == 'addZone')
        {
            $gardenName = $_SESSION["gardenName"];

            $name = htmlspecialchars($_POST['name']);
            $sun = $_POST['sun'];
            $water = $_POST['water'];

            try
            {
                $query = 'INSERT INTO zones(name, sunexposure, waterinches, gardenid) VALUES(:name, :sun, :water, :gardenid)';
                $statement = $db->prepare($query);
        

                $statement->bindValue(':name', $name);
                $statement->bindValue(':sun', $sun);
                $statement->bindValue(':water', $water);
                $statement->bindValue(':gardenid', $_SESSION["gardenId"]);
                $statement->execute();

            }
            catch (Exception $ex)
            {
                // Please be aware that you don't want to output the Exception message in
                // a production environment
                // echo "Error with DB. Details: $ex";
                die();
            }
        }
        elseif($type == 'updateZone')
        {
            $gardenName = $_SESSION["gardenName"];

            $name = htmlspecialchars($_POST['name']);
            $sun = $_POST['sun'];
            $water = $_POST['water'];
            $zoneId = $_POST['hidden2'];
            try
            {
                $query = 'UPDATE zones SET name = :name, sunexposure = :sun, waterinches = :water WHERE id = :zoneId';
                $statement = $db->prepare($query);
        

                $statement->bindValue(':name', $name);
                $statement->bindValue(':sun', $sun);
                $statement->bindValue(':water', $water);
                $statement->bindValue(':zoneId', $zoneId);
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

        
        if ($_SESSION["login"] != "true")
        {
            header("Location: https://sheltered-beyond-43060.herokuapp.com/garden.php" );
            die();
        }
        
        echo "<h1>$gardenName<h1>";
?>
         
        <h2> Create a New Zone </h2>
        <form method="post" action="myGarden.php">
            <input type="hidden" id="hidden" name="hidden"  value="addZone"></input>
            <label> Zone Name: </label>
            <input type="text" id="name" name="name" placeholder="Front Garden"></input>
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
<?

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
            echo "<h2> Zone: $zoneName  ";
            echo "<a class='submit' href='https://sheltered-beyond-43060.herokuapp.com/zoneChange.php?zone=$id'>Change Attributes of this Zone</a><br></h2>";
            echo "<a class='zone' href='https://sheltered-beyond-43060.herokuapp.com/plant.php?sun=$sun&water=$water&id=$id'>Add a plant to this Zone</a><br>";
          


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
                    echo "<table style='width:65%'><tr>
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

            
        }




        ?>
    
        

        
        
    </body>
</html>
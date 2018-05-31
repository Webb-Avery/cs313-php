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

            
        <?php

        $type = $_POST['hidden'];
    
        if($type == 'signup') 
        {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
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
           
                $garden = $firstname . ' Garden';
                $newStatement = $db->prepare($newQuery); 
                $newStatement->bindValue(':garden', $garden);
                $newStatement->bindValue(':userId', $userId);
                $newStatement->execute();

                echo "<h1>$garden</h1>";
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
                    echo "<p>Login Correctly</p>";

                    $userId = $user["id"];
                    $query = "SELECT name, id FROM gardens WHERE userid = :userId ";
                    $statement = $db->prepare($query);
                    $statement->bindValue(":userId", $userId, PDO::PARAM_STR);
                    $statement->execute();
                    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $garden)
                    {
                        $gardenName = $garden["name"];
                        echo "<h1>$gardenName</h1>";
                    }       
                }
                else
                {
                    echo "<p>Login failed</p>";
                }
            }
        }
    
    
        ?>
        
    </body>
</html>
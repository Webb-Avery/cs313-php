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
try
{

$type = $_POST['hidden'];
echo "<p>$type</p>";
if(type == 'signup') {
    $firstname = $_POST['firstname'];
    $lasttname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

  /*  
    try
    {
        // Add the Scripture
        // We do this by preparing the query with placeholder values
        $query = 'INSERT INTO users(firstname, lastname, username, password) VALUES(:firstname :lastname, :username, :password)';
        $statement = $db->prepare($query); 
        // Now we bind the values to the placeholders. This does some nice things
        // including sanitizing the input with regard to sql commands.
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();

        echo "<p>'Successfull'</p>";
    
    }
    catch (Exception $ex)
    {
        // Please be aware that you don't want to output the Exception message in
        // a production environment
        echo "Error with DB. Details: $ex";
        die();
    }
    */
}
?>

</body>
</html>
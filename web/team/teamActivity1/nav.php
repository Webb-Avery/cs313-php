<header>
    <h1>Garden Closet</h1>
    <?php
    if(isset($_SESSION["user"])) {
        echo "<p>Welcome $_SESSION[user]</p>";
        echo "<form method='post' action='home.php'><input type='submit' value='Logout'><input type='hidden' name='logout' value='logout'></form>";
    }
    else {
        echo "<p>Welcome. You are not logged in</p>";
    }
    ?>
    
</header>
<nav>
    <a <?php  if($current == 'about-us') {echo "class='current'";}?> href="about-us.php">About Us</a>
    <a <?php  if($current == 'home') {echo "class='current'";}?> href="home.php">Home</a>
    <a <?php  if($current == 'login') {echo "class='current'";}?> href="login.php">Login</a>
</nav>

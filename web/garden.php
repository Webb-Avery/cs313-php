

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
    <body>

        <h2>Login</h2>
        <form method="post" action="myGarden.php">
            <input type="hidden" id="hidden" name="hidden" value="login"></input>

            <label> Username: </label>
            <input type="text" id="username" name="username"></input>
            <br />
            
            <label> Password: </label>
            <input type="text" id="password" name="password"></input>
            <br />

            <input type="submit" value="Login!">
        </form>

        <h2> Sign Up! </h2>
        <form method="post" action="myGarden.php">
            <input type="hidden" id="hidden" name="signup"></input>
            <label> First Name: </label>
            <input type="text" id="firstName" name="firstName"></input>
            <br />

            <label> Last Name: </label>
            <input type="text" id="lastName" name="lastName"></input>
            <br />

            <label> Username: </label>
            <input type="text" id="username" name="username"></input>
            <br />
            
            <label> Password: </label>
            <input type="text" id="password" name="password"></input>
            <br />

            <input type="submit" value="Sign Up!">
        </form>
    </body>
</html>
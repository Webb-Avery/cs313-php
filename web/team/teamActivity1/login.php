<?php
$current = 'login';

session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php include($_SERVER['DOCUMENT_ROOT']."/cs313/teamActivity1/nav.php"); ?>
        <div id="container">
            <main>
                <section>
                    <h2>Login</h2>
                    <form method="post" action="home.php">
                        <input type="submit" value="Login as Administrator">
                        <input type="hidden" name="user" value="Administrator">
                    </form>
                    <form method="post" action="home.php">
                        <input type="submit" value="Login as Tester">
                        <input type="hidden" name="user" value="Tester">
                    </form>
                </section>
            </main>
        </div>
        <footer>

        </footer>
    </body>
</html>
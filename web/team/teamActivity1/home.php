<?php
$current = 'home';

session_start();

$user = filter_input(INPUT_POST, 'user');
$_SESSION["user"] = $user;

$logout = filter_input(INPUT_POST, 'logout');
if($logout == "logout") {
    session_destroy();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
       <?php include($_SERVER['DOCUMENT_ROOT']."/cs313/teamActivity1/nav.php"); ?>
        <div id="container">
            <main>
                <section>
                    <h2>Featured Products</h2>
                    <ul>
                        <li>Blueberry Plants</li>
                        <li>HyperTech Advanced Trowel</li>
                        <li>TerraCorp Shovel</li>
                    </ul>
                </section>
            </main>
        </div>
        <footer>

        </footer>
    </body>
</html>

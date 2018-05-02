<!DOCTYPE html>
<html>

    <head>
        <title>Documetn</title>
    </head>
    <body>
        <p>This is a php page</p>
        
        <?php 
        $x = 4 + "cat";
        echo "<p>$x</p>";
        
        for ($x = 0; $x < 10; $x++)
        {
            echo "<div id = 'div$x'> </div>";
        }
    </body>
</html>
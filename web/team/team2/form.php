<?php
$majors = ["CS", "WDD", "CIT", "CE"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form action="script.php" method="post">
            
            <p>Name:<input type="text" name="name"></p>
            <p>Email:<input type="text" name="email"></p>

            <p>Major:</p>
           
            <?php
            echo "<ul>";

            foreach ($majors as $major) {
                echo "<li>$major<input type='radio' name='major' value='$major'></li>";
            }

            echo "</ul>";
            ?>

            <p>Comment: <textarea name="comments" ></textarea></p>
            <ul>
                <li>North America<input type="checkbox" value="na" name="continents[]"></li>
                <li>South America<input type="checkbox" value="sa" name="continents[]"></li>
                <li>Europe<input type="checkbox" value="eu" name="continents[]"></li>
                <li>Asia<input type="checkbox" value="as" name="continents[]"></li>
                <li>Australia<input type="checkbox" value="au" name="continents[]"></li>
                <li>Africa<input type="checkbox" value="af" name="continents[]"></li>
                <li>Antarctica<input type="checkbox" value="an" name="continents[]"></li>
            </ul>

            <input type="submit">
        </form>
    </body>
</html>

    
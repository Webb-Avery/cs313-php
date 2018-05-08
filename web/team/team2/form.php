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
                <li>North America<input type="checkbox" value="North America" name="continents[]"></li>
                <li>South America<input type="checkbox" value="South America" name="continents[]"></li>
                <li>Europe<input type="checkbox" value="Europe" name="continents[]"></li>
                <li>Asia<input type="checkbox" value="Asia" name="continents[]"></li>
                <li>Australia<input type="checkbox" value="Australia" name="continents[]"></li>
                <li>Africa<input type="checkbox" value="Africa" name="continents[]"></li>
                <li>Antarctica<input type="checkbox" value="Antarctica" name="continents[]"></li>
            </ul>

            <input type="submit">
        </form>
    </body>
</html>

    
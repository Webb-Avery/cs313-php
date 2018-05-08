<?php 
$name = $_POST["name"];
$email = $_POST["email"];
$major = $_POST["major"];
$comments = $_POST["comments"];
$code = array("na"=>"North America", "sa"=>"South America", "eu"=>"Europe", "as"=>"Asia", "au"=>"Australia", "af"=>"Africa", "an"=>"Antarctica");

$html = "<p>The user's name is $name.</p> 
<p><a href='mailto: $email'>mailto: $email</a></p> 
<p>Major: $major</p>
<p>Comment: $comments</p>";

echo $html;

echo "<ul>";

foreach ($_POST["continents"] as $visited) {
    $visited = $code[$visited];
    echo "<li>$visited</li>";
}

echo "</ul>";

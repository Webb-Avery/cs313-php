<?php 
$name = $_POST["name"];
$email = $_POST["email"];
$major = $_POST["major"];
$comments = $_POST["comments"];


$html = "<p>The user's name is $name.</p> 
<p><a href='mailto: $email'>mailto: $email</a></p> 
<p>Major: $major</p>
<p>Comment: $comments</p>";

echo $html;

echo "<ul>";

foreach ($_POST["continents"] as $visited) {
    echo "<li>$visited</li>";
}

echo "</ul>";

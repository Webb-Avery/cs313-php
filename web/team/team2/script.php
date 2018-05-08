<?php 
$name = $_POST["name"];
$email = $_POST["email"];
$major = $_POST["major"];
$comments = $_POST["comments"];


$html = "<p>The user's name is $name.</p> 
<p>mailto: $email</p> 
<p>Major: $major</p>
<p>Comment: $comments</p>";

echo $html;

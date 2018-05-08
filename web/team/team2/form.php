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
            <ul> 
                <li>CS <input type="radio" name="major" value="CS"></li>
                <li>WDD<input type="radio" name="major" value="WDD"></li>
                <li>CIT<input type="radio" name="major" value="CIT"></li>
                <li>CE<input type="radio" name="major" value="CE"></li>
            </ul>

            <p>Comment: <textarea name="comments" ></textarea></p>
            <ul>
                <li><input type="checkbox" value="North America" name="continents[]"></li>
                <li><input type="checkbox" value="South America" name="continents[]"></li>
                <li><input type="checkbox" value="Europe" name="continents[]"></li>
                <li><input type="checkbox" value="Asia" name="continents[]"></li>
                <li><input type="checkbox" value="Australia" name="continents[]"></li>
                <li><input type="checkbox" value="Africa" name="continents[]"></li>
                <li><input type="checkbox" value="Antarctica" name="continents[]"></li>
            </ul>

            <input type="submit">
        </form>
    </body>
</html>

    
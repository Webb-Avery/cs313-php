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
                <li>CS <input type="radio" name="major"></li>
                <li>WDD<input type="radio" name="major"></li>
                <li>CIT<input type="radio" name="major"></li>
                <li>CE<input type="radio" name="major"></li>
            </ul>

            <p>Comment: <textarea name="comments" ></textarea></p>

            <input type="submit">
        </form>
    </body>
</html>

    
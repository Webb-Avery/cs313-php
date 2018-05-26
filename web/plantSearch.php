<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="main.css">
    <title>Plants</title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>

    <h1>Plants</h1>

        <form action="plant.php" method="get">
            
            Sun Exposure <select name="sun">
                <option value="sun">Full Sun </option>
                <option value="part">Part Sun</option>
                <option value="shade">Full Shade</option>
            </select>

            <input type="submit">
        </form>

        </body>
</html>
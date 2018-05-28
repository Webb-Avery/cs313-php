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
            
            Sun Exposure <select>
                <option value="FullSun" name="FullSun">Full Sun </option>
                <option value="PartSun" name="PartSun">Part Sun</option>
                <option value="FullShade" name="FullShade">Full Shade</option>
            </select>

            <input type="submit">
        </form>

        </body>
</html>
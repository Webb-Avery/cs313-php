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
                <option value="FullSun">Full Sun </option>
                <option value="PartSun">Part Sun</option>
                <option value="FullShade">Full Shade</option>
            </select>

            Water needed <select name="water">
                <option value="1">1 inch per week </option>
                <option value="PartSun">2 inches per week</option>
                <option value="FullShade">3 inches per week</option>
                <option value="">Any</option>
            </select>
            Life Cycle <select name=life>
                <option value="perennial" name="perennila">Perennial </option>
                <option value="annual" name="annual">Annual</option>
            </select>
            <br>
            <input type="submit">
        </form>

        </body>
</html>
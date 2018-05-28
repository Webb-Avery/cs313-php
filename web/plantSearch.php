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
                <option value="fullsun">Full Sun </option>
                <option value="partsun">Part Sun</option>
                <option value="fullshade">Full Shade</option>
                <option value="none">No Preference</option>
            </select>
<br>
            Water needed <select name="water">
                <option value="1">1 inch per week </option>
                <option value="2">2 inches per week</option>
                <option value="3">3 inches per week</option>
                <option value="none">No Preference</option>
            </select>
            <br>
            Life Cycle <select name=life>
                <option value="perennial" name="perennila">Perennial </option>
                <option value="annual" name="annual">Annual</option>
                <option value="none">No Preference</option>
            </select>
            <br>
            <input type="submit">
        </form>

        </body>
</html>
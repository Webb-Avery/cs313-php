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
                <option value="Full Sun" name="Full Sun">Full Sun </option>
                <option value="Part Sun" name="Part Sun">Part Sun</option>
                <option value="Full Shade" name="Full Shade">Full Shade</option>
            </select>

            <input type="submit">
        </form>

        </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>draw.smthg</title>
        <link rel="shortcut icon" href="../style/favicon.ico">
    </head>
    <body>
        <div>
            <h1>Invalid Request</h1>
            <h2>
                <?php
                if (!empty($_GET["error"]))
                {
                    echo $_GET["error"];
                }
                ?>
            </h2>
            <div>Sorry, you've made an invalid request. Please <a href="index.php">go back to menu</a> </div>
        </div>   
    </body>  
</html>
<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: login.php");
        exit(); 
    }
    require('../database/CRUD.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../style/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../style/main.css?version=5">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="../lib/p5.js"></script>
        <title>draw.smthg</title>
        <link rel="shortcut icon" href="../style/favicon.ico">
    </head>
    <body>

        <div class="menu" >
            <a href="index.php" id="pages">Draw Area</a>
            <a href="museum.php" id="pages">Museum</a>
            <a href="logout.php" id="logout">Logout</a>

            <div id="word-container">
                <p id="word-title">Word of the day :</p>
                <?php
                    $list = find("word",array("date" => date("y_m_d")));
                    if ($list != null && sizeof($list) == 1)
                    {
                        $word = $list[0];
                        echo "<div id='word'>".$word["word"]."</div>";
                    }
                ?>
            </div>

        </div>

        <div class="app">

            <div class="controls">

                <div class="title">Draw it ! </div>

                <div class="type">

                    <input type="radio" name="pen-type" id="pen-pencil" checked>
                    <label for="pen-pencil">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </label>

                    <input type="radio" name="pen-type" id="pen-brush" checked>
                    <label for="pen-brush">
                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                    </label>

                </div>

                <div class="size">
                    <label for="pen-size">Size</label>
                    <input type="range" id="pen-size" min="1" max="50">
                </div>

                <div class="color">
                    <label for="pen-color">Color</label>
                    <input type="color" id="pen-color" value="#000">
                </div>

                <div class="actions">
                    <button id="reset-canvas">Reset</button>
                    <button id="save-canvas">Save</button>
                    <?php

                        $list = find("draw",array(  "username_id"   =>  $_SESSION["id"],
                                                    "date"          =>  date("Y-m-d")));
                        if ($list == null)
                        {
                            echo '<button id="upload-canvas">Upload</button>';
                        }
                        else{
                            echo '<button id="upload-canvas" title="come back tomorow!" disabled>Upload</button>';
                        }
                        
                    ?>
                </div>

            </div>

            <div id="canvas-wrapper"></div>

        </div>
        <script src="./canva.js"></script>
    <body>
</html>
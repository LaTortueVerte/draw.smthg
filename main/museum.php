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
        </div>

        <input type="date" id="date_select" name="trip-start" value="<?php echo date("Y-m-d"); ?>" min="2022-09-01" max="<?php echo date("Y-m-d"); ?>">
        <p>                
            <?php
                $list = find("word",array("date" => date("y_m_d")));
                if ($list != null && sizeof($list) == 1)
                {
                    $word = $list[0];
                    echo "<div id='word_museum'>".$word["word"]."</div>";
                }
            ?>
        </p>

        <div class="list_of_draw">

        </div>
        
        <script>
            
            function get_draw(){
                $.ajax({
                    url: '../database/functions.php',
                    type: 'post',
                    data: {
                        'date':$( "#date_select" ).val()
                    },
                    success: function (data) {
                        let json_data = JSON.parse(data);
                        $(".list_of_draw").empty(); // empty div
                        let n = 0;
                        let to_add = "";
                        json_data.forEach( element => { //add paintings in draw
                            
                            if (n % 3 == 0) to_add += "<tr>";
                            to_add += "<td><img class='draw' src=" + element.root + "><p class='author'> By " + element.username + "</p></td>";
                            if (n % 3 == 2 || n == json_data.length - 1) to_add += "</tr>";
                            n += 1;
                        })
                        console.log(to_add);
                        $(".list_of_draw").append(to_add);
                        
                    },
                    error: function (data) {
                        console.log("error in data receiving");
                    }
                });
            }
            get_draw();

            $( "#date_select" ).change(function() {
                get_draw();
            });

        </script>
    <body>
</html>
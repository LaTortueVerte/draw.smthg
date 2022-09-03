<?php

require('../database/CRUD.php');
session_start();

if (!empty($_POST["send_img"]) || !empty($_POST["data"])){

    $list = find("draw",array(  "username_id"   =>  $_SESSION["id"],
                                "date"          =>  date("Y-m-d")));
    if ($list == null){

        if (!file_exists("../draw/".date("y_m_d"))) {
            mkdir("../draw/".date("y_m_d"), 0777, true);
        }
    
        $root = "../draw/".date("y_m_d")."/".$_SESSION['id']."-".date("y_m_d").".png";
    
        if(create("draw", array(    "username_id"   =>  $_SESSION['id'],
                                    "score"         =>  0,
                                    "root"          =>  $root)))
        {
            $p = file_put_contents($root, base64_decode($_POST['data']));
            if ($p == 0){
                echo "saving file error";
            }
            else{
                echo "file saved";
            }
        }
        else{
            echo "database error";
        }
    }
    else{
        echo "file already saved";
    }
}

if (!empty($_POST["date"])){
    require('config.php');
    $query = "SELECT d.score,d.root,d.date,u.username FROM draw d INNER JOIN user u ON d.username_id = u.id  WHERE date = '".$_POST["date"]."';";
    $result = mysqli_query($conn,$query); // Execute query to database
    if (!$result)// Process result / error
    {
        echo "error in database conn";
    }
    $list = array();
    while($row = mysqli_fetch_array($result))
    {   
        $n = 0;
        foreach ($row as $key => $value){
            if ($n % 2 == 0){
                unset($row[$key]); // Don't understand why but it works
            }
            $value = stripslashes($value);
            $n = ($n + 1) % 2;
        }
        
        array_push($list, $row);
    }

    // Send json to jquery
    echo json_encode($list); 
}
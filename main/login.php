<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/main.css?version=5">
    <title>draw.smthg</title>
    <link rel="shortcut icon" href="../style/favicon.ico">
</head>
<body>
    <?php
        require('../database/CRUD.php');
        session_start();

        if (isset($_POST['username']))
        {
            $username = stripslashes($_REQUEST['username']);

            $password = stripslashes($_REQUEST['password']);

            $list = find("user",array("username"=>$username, "password"=>hash('sha256', $password)));
            if ($list != null && sizeof($list) == 1)
            {
                $row = $list[0];

                $_SESSION['username'] = $username;
                $_SESSION['id'] = $row["id"];
                $_SESSION['email'] = $row["email"];

                // Go to menu

                header("Location: index.php");
            }
            else
            {
                $message = "username or / and password incorrect.";
            }
        }
    ?>

    <div id="login_form">
        <form  action="" method="post" name="login">

            <h1>Sign in</h1>

            <input type="text" name="username">
            <input type="password" name="password" minlength="8" autocomplete=off>

            <input type="submit" value="sign in" name="submit">

        </form>

        <button id="sign_out">sign out</button>

        <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
    </div>

    <script type="text/javascript">
        document.getElementById("sign_out").onclick = function () {
            location.href = "register.php";
        };
    </script>

<body>
</html>
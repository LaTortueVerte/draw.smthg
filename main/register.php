<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/main.css?version=5">
    <title>draw.smthg</title>
    <link rel="shortcut icon" href="../style/favicon.ico">
    <link rel="shortcut icon" href="../style/favicon.ico">
</head>
<body>
    <?php
        // Include files
        require('..\database\CRUD.php');
        // Define variables and initialize with empty values

        $username = $password = "";
        $username_err = $password_err = $unique_username = "";

        // Processing form data when form is submitted

        $condition = isset($_REQUEST['username'], $_REQUEST['password']);

        if ($condition)
        {
            // Valide username

            $input_username = $_POST["username"];

            if(empty($input_username))
            {
                $username_err = "Please enter a name.";
            } 
            elseif(!preg_match("/^[a-zA-Z0-9-_]*$/",$input_username))
            {
                $username_err = "Please enter a valid username, use only alphabetic characters, numbers and '_'.";
            } 
            else
            {
                $username = $input_username;
            }

            // Unique username

            $list = find("user",array("username"=>$username));
            if ($list != null)
            {
                $unique_username = "This username is already taken.";
            }

            // Validate password:

            $input_password = $_POST["password"];

            if (empty($input_password))
            {
                $password_err = " Please enter a password.";
            }
            else
            {
                $password = $input_password;
            }
        }

        if($condition && empty($username_err) && empty($password_err) && empty($unique_username))
        {
            if(create("user", array(   "username"          =>  $username,
                                        "password"          =>  hash('sha256', $password))))
            {
                echo "  <div id='login_form'>
                            <h3>You are successfully registered</h3>
                            <p>Clic here to <a href='login.php'>login</a></p>
                        </div>";
            }
            else
            {
                header("Location: error.php");
                exit();
            }
        }
        else
        {

            ?>

            <div id="login_form">
                <form action="" method="post">

                    <h1>Sign out</h1>

                    <div>

                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                        <span><?php echo $username_err;?></span>
                        <span class="error"><?php echo $unique_username;?></span>

                    </div>

                    <div>

                        <label>Password</label>
                        <input type="password" name="password" minlength="8" autocomplete=off>
                        <span class="error"><?php echo $password_err;?></span>

                    </div>

                    <input type="submit" name="submit" value="Sign up" />

                    <div id="login_in_register">
                        <p >Already register? </p>
                        <a href="login.php">Log in</a>
                    </div>

                </form>
            </div>

        <?php } ?>

</body>
</html>

<?php
// REFERENCES www.tutoralrepublic.com and stackoverflow.com.
// for validating and directing users when loggin in

session_start(); // Initialize session
 

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { // Check if the user is already logged in
    header("location: welcome.php"); // redirect if so
    exit;
}

require_once "config.php";
 
// Define and initialize
$username = $password = "";
$username_err = $password_err = $login_err = "";
 

if ($_SERVER["REQUEST_METHOD"] == "POST") { // processing form data
 
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate
    if(empty($username_err) && empty($password_err)){

    
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);  // Bind variables
            
            $param_username = $username;
            
            
            if(mysqli_stmt_execute($stmt)){ //execute

                mysqli_stmt_store_result($stmt);// store
                
                // Check and verify
                if(mysqli_stmt_num_rows($stmt) == 1){     

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);


                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {

                            //since password is correct start a new session
                            session_start();
                            
                            // Store data
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                          
                            header("location: welcome.php"); // Redirect 
                        } else {
                            // Password not valid, display error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="fav.css">
    <link rel="icon" type="image/gif" href="/images/fav.gif">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    
  <div class="header">
    <img src="/images/ob.png" alt="ob" />
   
  </div>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="alert1"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="alert1"><?php echo $password_err; ?></span> 
            </div>
            <div class="form-group">
                <input type="submit" class="log" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
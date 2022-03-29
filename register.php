


<?php
// REFERENCES www.tutoralrepublic.com and stackoverflow.com.
// for validating and directing users when registering in
// Include config file
require_once "config.php";
 
// Define variables
// initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// processing
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if (empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Invalid username";
    } else {

        $sql = "SELECT id FROM users WHERE username = ?";
        // sql query



        
        if ($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to select statement
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // parameters
            $param_username = trim($_POST["username"]);
            
            if (mysqli_stmt_execute($stmt)) { //execute the prepared statement
                mysqli_stmt_store_result($stmt); //store
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate
    if (empty(trim($_POST["password"]))){
         $password_err = "Please enter a password."; 

    } elseif (strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have 6 or more characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            // by using the built in function we can hash passwords
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
     
            if (mysqli_stmt_execute($stmt)) { //execute
                // Redirect

                header("location: login.php");
            } else {

            // more validation
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="fav.css">
    <link rel="icon" type="image/gif" href="/images/fav.gif">
</head>
<body>
<div class="header">
    <img src="/images/ob.png" alt="ob" />
   
  </div>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="alert1"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="alert1"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="alert1"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="sub" value="Submit">
                <input type="reset" class="sub" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>


<?php
// REFERENCES www.tutoralrepublic.com and stackoverflow.com.
//for cases where password needs to be reset. 
session_start(); //init session
 
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { // check if logged in a redirect if so
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define and initialize
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update query
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        // updating the database
        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to query
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            //parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="fav.css">
    <link rel="icon" type="image/gif" href="/images/fav.gif">
   
</head>
<body>
<div class="header">
    <img src="/images/ob.png" alt="ob" />
   
  </div>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="alert1"><?php echo $new_password_err; ?></span> 
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="alert1"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="sub" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>

        </form>
    </div>    
</body>
</html>
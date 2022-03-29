<?php
// REFERENCES www.tutoralrepublic.com and stackoverflow.com.
// connect
define('DB_SERVER', 'us-cdbr-east-05.cleardb.net');
define('DB_USERNAME', 'ba233c21653123');
define('DB_PASSWORD', '5e08f960');
define('DB_NAME', 'heroku_fd11d4bdf9cc4b6');
 
/* connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


<?php
// Dao.php
// class for saving and displaying favorite coins
require_once 'KLogger.php';
class Dao {

  private $logger = null;

  private $host = "us-cdbr-east-05.cleardb.net";
  private $db = "heroku_fd11d4bdf9cc4b6";
  private $user = "ba233c21653123";
  private $pass = "5e08f960";
  

  public function __construct() {
    $this->logger = new KLogger ( "log.txt" , KLogger::WARN );
  }

  public function getConnection () {
    $this->logger->LogDebug("getting a connection...");
    try {
      return
        new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    } catch (Exception $e) {
       $this->logger->LogFatal("The database exploded " . print_r($e,1));
       exit;
    }
  }
public function addFav($username, $favcoin) {
 $conn = $this->getConnection();
    $saveQuery =
        "INSERT INTO favcoins
        (fav_user, fav_coin)
        VALUES
        (:user, :coin)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":user", $username);
    $q->bindParam(":coin", $favcoin);
    $q->execute();
  }
  public function removeFav($username, $favcoin) {
    $conn = $this->getConnection();
    $deleteQuery = "DELETE FROM favcoins WHERE fav_user = :user AND fav_coin = :coin";
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":user", $username);
    $q->bindParam(":coin", $favcoin);
    $q->execute();
     }

public function getFav($username) {
    $conn = $this->getConnection();
    $query = "SELECT fav_user, fav_coin FROM favcoins WHERE fav_user = :user ";
    $q = $conn->prepare($query);
    $q->bindParam(":user", $username);
    $q->execute();
    $favs = $q->fetch();
    return $favs;

 }


}
?>

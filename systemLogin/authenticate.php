<?php
require 'conDB.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();



try {
  if ($pdo) {
    $stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE username = ?');

    if ($stmt) {
      $stmt->bindParam(1, $_POST['username']);
      $stmt->execute();

      $rowCount = $stmt->rowCount();

      if ($rowCount > 0){
         $result = $stmt->fetch(PDO::FETCH_ASSOC);

         if (password_verify($_POST['password'], $result['password'])){
           session_regenerate_id();

           $_SESSION['loggedin'] = TRUE;
           $_SESSION['name'] = $_POST['username'];
           $_SESSION['id'] = $result['id'];

           header('Location: home.php');
         }else {
           echo 'Incorrect Username and/or Password';
         }
      }else{
        echo 'Incorrect Username and/or Password';
      }
    }
  }

} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

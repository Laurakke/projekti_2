<?php $page = 'login'; include("includes/iheader.php");
?>

<?php include("includes/inavLogInUser.php"); ?>
<div id="banner"></div>

<?php include("forms/floginUser.php"); ?>

<?php

if(isset($_POST['submitUser'])){
 
  if(!filter_var($_POST['givenEmail'], FILTER_VALIDATE_EMAIL)){
   $_SESSION['swarningInput']="Illegal email";
  }else{
    unset($_SESSION['swarningInput']);  
     try {
      
      $data['email'] = $_POST['givenEmail'];
      $STH = $DBH->prepare("SELECT userName, userEmail, userPwd FROM Kirjautuminen WHERE userEmail = :email;");
      $STH->execute($data);
      $STH->setFetchMode(PDO::FETCH_OBJ);
      $tulosOlio=$STH->fetch();
     
      $givenPasswordAdded = $_POST['givenPassword'].$added; 
 
      
       if($tulosOlio!=NULL){
       
          if(password_verify($givenPasswordAdded,$tulosOlio->userPwd)){
              $_SESSION['sloggedIn']="yes";
              $_SESSION['suserName']=$tulosOlio->userName;
              $_SESSION['suserEmail']=$tulosOlio->userEmail;
              header("Location: index.php"); 
          }else{
            $_SESSION['swarningInput']="Wrong password";
          }
      }else{
        $_SESSION['swarningInput']="Wrong email";
      }
     } catch(PDOException $e) {
        file_put_contents('log/DBErrors.txt', 'logInUser.php: '.$e->getMessage()."\n", FILE_APPEND);
        $_SESSION['swarningInput'] = 'Database problem';
    }
  }
}
?>

<?php


if(isset($_POST['submitBack'])){
  session_unset();
  session_destroy();
  header("Location: index.php");
}
?>

<?php

if(isset($_SESSION['swarningInput'])){
  echo("<p class=\"warning\">ILLEGAL INPUT: ". $_SESSION['swarningInput']."</p>");
}
?>

<?php include("includes/ifooter.php");?>
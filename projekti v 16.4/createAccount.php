
<?php $page = 'create'; include("includes/iheader.php");
?>
<?php include("includes/inavIndex.php");
?>
<?php include("includes/inavCreateAccount.php");
?>
<div id="banner"></div>
<?php include("forms/fcreateAccount.php");
?>


<?php

if(isset($_POST['submitUser'])){
 
  if(strlen($_POST['givenUsername'])<4){
   $_SESSION['swarningInput']="Illegal username (min 4 chars)";
  }else if(!filter_var($_POST['givenEmail'], FILTER_VALIDATE_EMAIL)){
   $_SESSION['swarningInput']="Illegal email";
  }else if(strlen($_POST['givenPassword'])<8){
  $_SESSION['swarningInput']="Illegal password (min 8 chars)";
  }else if($_POST['givenPassword'] != $_POST['givenPasswordVerify']){
  $_SESSION['swarningInput']="Given password and verified not same";
  }else{
  unset($_SESSION['swarningInput']);
  

  $_SESSION['suserName']=$_POST['givenUsername'];
  $_SESSION['sloggedIn']="yes";
  $_SESSION['semail']= $_POST['givenEmail'];
  
  $data['name'] = $_POST['givenUsername'];
  $data['email'] = $_POST['givenEmail'];
  $added='#â‚¬%&&/'; 
  $data['pwd'] = password_hash($_POST['givenPassword'].$added, PASSWORD_BCRYPT);
  try {
   
    $sql = "SELECT COUNT(*) FROM Kirjautuminen where userEmail  =  " . "'".$_POST['givenEmail']."'"  ;
    $kysely=$DBH->prepare($sql);
    $kysely->execute();				
    $tulos=$kysely->fetch();
    if($tulos[0] == 0){ 
     $STH = $DBH->prepare("INSERT INTO Kirjautuminen (userName, userEmail, userPwd) VALUES (:name, :email, :pwd);");
     $STH->execute($data);
     header("Location: index.php"); 
    }else{
      $_SESSION['swarningInput']="Email is reserved";
    }
  } catch(PDOException $e) {
    file_put_contents('log/DBErrors.txt', 'logInUser.php: '.$e->getMessage()."\n", FILE_APPEND);
    $_SESSION['swarningInput'] = 'Database problem';
    
  }
}

  
  header("Location: index.php");
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
<?php include("includes/ifooter.php");
?>
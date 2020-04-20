<nav>
<?php

if($_SESSION['sloggedIn']=="yes"){
     echo( "<p> Tervetuloa: " .$_SESSION['suserName']. " " );
     ?>
    <li class="<?php if ($page =='home'){echo 'active';}?>"><a href="index.php">Etusivu</a></li>
    <li class="<?php if ($page =='tieto'){echo 'active';}?>"><a href="tietosivu.php">Tietosivu</a></li>
    <li class="<?php if ($page =='profiili'){echo 'active';}?>"><a href="Profiili.php">Profiili</a></li>
    <li><a href="logOutUser.php">  Kirjaudu ulos</a></li>
     <?php
     
}else{
    echo( "<p> <br>" );
    ?>
    <li class="<?php if ($page =='create'){echo 'active';}?>"><a href="createAccount.php">Luo tili</a></li>
    <li class="<?php if ($page =='login'){echo 'active';}?>"><a href="logInUser.php">Kirjaudu sisään</a></li>
    <?php
}

?>
</nav>

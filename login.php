<?php
//Logi vorm andmebaasis salvestatud kasutajanimega ja prooliga

session_start();
if(isset($_SESSION['tuvustamine'])){
    header('Location: konkurs.php');
    exit();
}
//login ja pass kontorll
if (!empty($_POST['loginName']) && !empty($_POST['password'])){
    $login=$_POST['loginName'];
    $pass=$_POST['password'];

    $sool='vagavagatekst';
    $krypt=crypt($pass, $sool);
    //kontrollime kas andmebaasis on selline kasutaja
    require("conf.php");
    global $yhendus;
    $kask=$yhendus->prepare("SELECT nimi, onAdmin, koduleht FROM kasutajad WHERE nimi=? AND parool=?");
    $kask->bind_param("ss", $login,$krypt);
    $kask -> bind_result($nimi,$onAdmin,$koduleht);
    $kask->execute();

    if ($kask->fetch()){
        $_SESSION['tuvustamine'] = 'niilihtne';
        $_SESSION['kasutaja']=$nimi;
        $_SESSION['onAdmin']=$onAdmin;
        if (isset($koduleht)){
            header("Location: konkurs.php");
        }else{
            header('Location: konkurs.php');
            exit();
        }
    }else{
        echo "kasutaja $login või parool $krypt on vale";
    }
}


?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="tyle.css">
    <title>Login</title>
</head>
<body>
<h1>Login vorm</h1>

<form action="" method="post">
    Login:
    <input type="text" name="loginName" placeholder="kasutaja nimi">
    <br>
    Parool:
    <input type="password" name="password">
    <br>
    <input type="submit" value="Logi sisse">


</form>



</body>
</html>

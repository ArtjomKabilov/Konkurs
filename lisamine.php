<?php
require('conf.php');
global $yhendus;

session_start();
if(!isset($_SESSION['tuvustamine'])) {
    header('Location: login.php');
    exit();
}

if(isset($_REQUEST['nimi'])) {
    $kask = $yhendus->prepare("INSERT INTO konkurss(nimi,pilt,lisamisaeg)
VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Fotokonkurss</title>
    <link rel="stylesheet" href="tyle.css">
</head>
<body>
<nav class="topnav">
    <a href="konkurs.php">Kasutaja leht</a>
    <a href="haldus.php">Administreerimise leht</a>


    <a href="lisamine.php">Lisamine</a>


    <a href="https://github.com/ArtjomKabilov/Konkurs">GitHub</a>
    <div class="dot"></div>
</nav>

<div class="knopka">
    <p><?= $_SESSION["kasutaja" ]?> on sisse loogitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
</div>
<h1>Fotokonkurss "loodus" halduse</h1>
<?php
//tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi,pilt, lisamisaeg,punktid, kommentaar, avalik FROM konkurss");
$kask->bind_result($id,$nimi,$pilt,$aeg,$pun,$kom,$avalik);
$kask->execute();
?>
<h2>Uue pilti lisamine konkurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="uus nimi">
    <br>
    <textarea name="pilt">pildi linki aadress</textarea>
    <br>
    <input type="submit" value="Lisa">

</form>
</body>
</html>
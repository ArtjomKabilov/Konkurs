<?php
require_once ('conf.php');
global $yhendus;

session_start();
if(!isset($_SESSION['tuvustamine'])){
    header('Location: login.php');
    exit();
}

//punktide nulliksa UPDATE
if(isset($_REQUEST['punkt'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET punktid=0 where id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
//Nimi naitamine avalik=1
if(isset($_REQUEST['peitmine'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET avalik=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();

}
if(isset($_REQUEST['avamine'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['avamine']);
    $kask->execute();

}

if(isset($_REQUEST['kustuta'])) {
    $kask = $yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $kask->bind_param("i", $_REQUEST['kustuta']);
    $kask->execute();
}
if(isset($_REQUEST['kom'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET kommentaar=' ' where id=?");
    $kask->bind_param("s", $_REQUEST['kom']);
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
    <a href="konkurs.php">kasutaja leht</a>
    <a href="haldus.php">Administreerimise leht</a>
    <?php
    if ($_SESSION['onAdmin']==1){
        echo "<a href='lisamine.php'>Lisamine</a>";
    }
    ?>
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

echo "<table>";
echo "<tr>
<th></th>
<th></th>
<th></th>
<th></th>
<th>Nimi</th>
<th>pilt</th>
<th>lisamisaeg</th>
<th>kommentaar</th>
<th>punktid</th>
</tr>";
//fetch() - извлечение данных из набора данных
while ($kask->fetch()) {
    echo "<tr>";
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    $txt='"Kas sa tahad kustutada aeda fotod"';
    echo "<td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='?kustuta=$id' onclick='return confirm($txt)'>Kustuta</a></td>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt>'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$kom</td>";
    echo "<td>$pun</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a> <br>
            <a href='?kom=$id'>Kommetn nulliks</a>

    </td>";
    //Peida-näita

    echo "</tr>";
}
?>


</form>
</body>
</html>
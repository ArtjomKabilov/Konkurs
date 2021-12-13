<?php
require_once ('conf.php');
global $yhendus;
//punktide nulliksa UPDATE
if(isset($_REQUEST['punkt'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET punktid=0 where id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
//Nimi lisamine konkurssi
if(isset($_REQUEST['nimi'])) {
    $kask = $yhendus->prepare("INSERT INTO konkurss(nimi,pilt,lisamisaeg)
VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'],$_REQUEST['pilt']);
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
    <a href="konkurs.php">Administreerimise leht</a>
    <a href="haldus.php">Kasutaja leht</a>
    <div class="dot"></div>
</nav>
<h1>Fotokonkurss "" halduse</h1>
<?php
//tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi,pilt, lisamisaeg, punktid, avalik FROM konkurss");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid,$avalik);
$kask->execute();

echo "<table>";
echo "<tr>
<th>Nimi</th>
<th>pilt</th>
<th>lisamisaeg</th>
<th>punktid</th>
</tr>";
//fetch() - извлечение данных из набора данных
while ($kask->fetch()) {
    echo "<tr>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt>'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</a></td>";
    //Peida-näita
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    echo "<td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
    echo "</tr>";
}
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
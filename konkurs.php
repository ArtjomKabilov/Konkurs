<?php
require_once ('conf.php');
global $yhendus;
//punktide lisamine UPDATE
if(isset($_REQUEST['uus_komment'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET kommentaar=CONCAT(kommentaar, ?) where id=?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask->bind_param("si",$kommentlisa, $_REQUEST['uus_komment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
//uue kommentaari lisamine
if(isset($_REQUEST['punkt'])) {
    $kask = $yhendus->prepare("UPDATE konkurss SET punktid=punktid+1 where id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
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
    <div class="dot"></div>
</nav>
<h1>Fotokonkurss "loodus"</h1>
<?php
//tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi,pilt, kommentaar, punktid FROM konkurss WHERE avalik=1");
$kask->bind_result($id,$nimi,$pilt,$kom,$punktid);
$kask->execute();

echo "<table>";
echo "<tr>
<th>Nimi</th>
<th>pilt</th>
<th>Kommentaarid</th>
<th>Lisa Kommentaar</th>
</tr>";
//fetch() - извлечение данных из набора данных
while ($kask->fetch()) {
    echo "<tr>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt>'></td>";
    echo "<td>".nl2br($kom)."</td>";
    echo "<td>
    <form action='?'>
        <input type='hidden' name='uus_komment' value='$id'>
        <input type='tex' name='komment'>
        <input type='submit' value='OK'>
    </form></td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    echo "</tr>";

}
?>


</body>
</html>

<?php
require_once ('conf.php');
global $yhendus;
//punktide lisamine UPDATE
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
    <a href="konkurs.php">Administreerimise leht</a>
    <a href="haldus.php">Kasutaja leht</a>
    <div class="dot"></div>
</nav>
<h1>Fotokonkurss ""</h1>
<?php
//tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi,pilt, lisamisaeg, punktid FROM konkurss WHERE avalik=1");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid);
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
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    echo "</tr>";

}
?>


</body>
</html>

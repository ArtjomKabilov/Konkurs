<?php
$serverinimi='localhost';
$kasutajanimi='artjomK';
$parool='123454321';
$adnmebaasinimi='artjom';
$yhendus=new mysqli($serverinimi,$kasutajanimi,$parool,$adnmebaasinimi);
$yhendus->set_charset('UTF8');


/*CREATE TABLE konkurss(
    id int primary KEY AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaar text DEFAULT ' ',
    avalik int DEFAULT 1
)*/
?>


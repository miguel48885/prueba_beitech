<?php
//host=beitech-sas.ccnlcdeiv1f1.us-east-1.rds.amazonaws.com
//database: test
//user: beitech_test
//pass: K#j~t33@M}
//port: 3306


 
//$databaseHost = 'localhost';
//$nombrebd = 'bd_plannen';
//$usuariobd = 'root';
//$Passwordbd = 'Colombia123';

$databaseHost = 'beitech-sas.ccnlcdeiv1f1.us-east-1.rds.amazonaws.com';
$nombrebd = 'test';
$usuariobd = 'beitech_test';
$Passwordbd = 'K#j~t33@M}';
$portbd='3306';
 
$mysqli = mysqli_connect($databaseHost, $usuariobd, $Passwordbd, $nombrebd,$portbd); 
?>
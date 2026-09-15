<?php

$server = "localhost"; 
$user = "root"; 
$lozinka = ""; 
$baza = "projekat_pva";

$dbc = mysqli_connect($server, $user, $lozinka, $baza); 
if(!$dbc) 
    die("Greska pri povezivanju sa bazom podataka!"); 
mysqli_set_charset($dbc, "utf8");
?>
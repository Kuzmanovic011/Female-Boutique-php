<?php 
session_start(); 
if(isset($_GET["id"])){ 
    $id = $_GET["id"]; 
    if(isset($_SESSION["korpa"][$id])) 
    unset($_SESSION["korpa"][$id]); 
} 
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
?>


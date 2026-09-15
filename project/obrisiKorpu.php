<?php
session_start();

unset($_SESSION["korpa"]); // brisanje iz memorije

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>
<?php 
session_start();
require_once "konekcija.php";
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: adminPanel.php");
    exit();
}
$greske = [];
if(isset($_POST["btnAdminIzmeni"])) {
    $idArtikla = $_POST["idProizvodaIzmena"] ?? null;
    $kolicinaArtikla = $_POST["kolicinaProizvodaIzmena"];
    $cenaArtikla = $_POST["cenaProizvodaIzmena"];
    $upit = "";
    
    if(!isset($idArtikla)){
        $_SESSION["uspesnoAdmin"] = "Nije odabran idArtikla";
        header("Location: adminPanel.php");
        exit();
    }

    if(empty($kolicinaArtikla) && empty($cenaArtikla)){
        $_SESSION["uspesnoAdmin"] = "Niste odabrali ni cenu ni kolicinu za izmenu";
        header("Location: adminPanel.php");
        exit();
    }

    else if(!empty($kolicinaArtikla) && !empty($cenaArtikla)){
        $upit = "UPDATE artikli
                 SET cenaArtikla = ?, kolicinaArtikla = ? 
                 WHERE idArtikla = $idArtikla";
        $stmt = mysqli_prepare($dbc, $upit);
        mysqli_stmt_bind_param($stmt, "ii", $cenaArtikla, $kolicinaArtikla);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)>0){
            $_SESSION["uspesnoAdmin"] = "Uspesna izmena!";
            mysqli_stmt_close($stmt);
            header("Location: adminPanel.php");
            exit();
        } else {
            $_SESSION["uspesnoAdmin"] = "Nepesna izmena!";
            header("Location: adminPanel.php");
            exit();
            }

    }
    else if(empty($kolicinaArtikla) && !empty($cenaArtikla)) {
        $upit = "UPDATE artikli
                 SET cenaArtikla = ? 
                 WHERE idArtikla = $idArtikla";
        $stmt = mysqli_prepare($dbc, $upit);
        mysqli_stmt_bind_param($stmt, "i", $cenaArtikla);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)>0){
            $_SESSION["uspesnoAdmin"] = "Uspesna izmena!";
            mysqli_stmt_close($stmt);
            header("Location: adminPanel.php");
            exit();
        }else  {
            $_SESSION["uspesnoAdmin"] = "Nepesna izmena!";
            header("Location: adminPanel.php");
            exit();
            }
    }
    else if(!empty($kolicinaArtikla) && empty($cenaArtikla)) {
        $upit = "UPDATE artikli
                 SET kolicinaArtikla = ? 
                 WHERE idArtikla = $idArtikla";
        $stmt = mysqli_prepare($dbc, $upit);
        mysqli_stmt_bind_param($stmt, "i", $kolicinaArtikla);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)>0){
            $_SESSION["uspesnoAdmin"] = "Uspesna izmena!";
            mysqli_stmt_close($stmt);
            header("Location: adminPanel.php");
            exit();
        } else {
            $_SESSION["uspesnoAdmin"] = "Nepesna izmena!";
            header("Location: adminPanel.php");
            exit();
            }
    }
    
}

?>
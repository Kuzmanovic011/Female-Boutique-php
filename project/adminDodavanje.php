<?php 
session_start();
require_once "konekcija.php";
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: adminPanel.php");
    exit();
}
$greske = [];
if(isset($_POST["btnAdminDodaj"])) {
    if(!isset($_SESSION["adminGreske"]))
    $_SESSION["adminGreske"] = [];
    $nazivArtikla = trim($_POST["nazivProizvoda"]);
    $nazivArtikla = mysqli_real_escape_string($dbc, $nazivArtikla);
    $tipArtikla = trim($_POST["tipProizvoda"]);
    $kolicinaArtikla = trim($_POST["kolicinaProizvoda"]);
    $cenaProizvoda = trim($_POST["cenaProizvoda"]);
    $opisProizvoda = trim($_POST["opisProizvoda"]);
    $opisProizvoda = mysqli_real_escape_string($dbc, $opisProizvoda);
    $dat = proveraDatoteka();
    
    if(empty($nazivArtikla) || empty($tipArtikla) || empty($kolicinaArtikla) || empty($cenaProizvoda)) {
        $greske[] = "Morate uneti sva obavezna polja";
    }

    if(empty($opisProizvoda)) {
        $opisProizvoda = "Nije unet opis";
    }

   if($kolicinaArtikla <1) {
    $greske[] = "Kolicina mora biti veca od 0";
   }

   if($cenaProizvoda<1) {
     $greske[] = "Cena proizvoda mora biti veca od 0";
   }

   if(!empty($greske)) {
        $_SESSION["adminGreske"] = $greske;
        header("Location: adminPanel.php");
        exit();
   }

   if($dat !== null){
        $_SESSION["adminGreske"][] = $dat;
        header("Location: adminPanel.php");
        exit();
    }

    $slikaArtikla = $_FILES["fotografijaProizvoda"]["name"];
    move_uploaded_file(
        $_FILES["fotografijaProizvoda"]["tmp_name"],
        "slike/".basename($slikaArtikla)
    );

    $upit = "INSERT INTO artikli 
             (nazivArtikla, tipArtikla, kolicinaArtikla, cenaArtikla, slikaArtikla, opisArtikla)
             VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $upit);
    mysqli_stmt_bind_param($stmt, "ssiiss", $nazivArtikla, $tipArtikla, $kolicinaArtikla, $cenaProizvoda, $slikaArtikla ,$opisProizvoda);         
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: adminPanel.php");
    exit();
    }
else
    {

    }


function proveraDatoteka(){

    if(!isset($_FILES["fotografijaProizvoda"]))
        return "Niste uneli sliku.";

    if($_FILES["fotografijaProizvoda"]["error"] !== UPLOAD_ERR_OK)
        return "Greška pri uploadu.";

    $tip = $_FILES["fotografijaProizvoda"]["type"];
    $velicina = $_FILES["fotografijaProizvoda"]["size"];

    $dozvoljeniTipovi = ["image/jpeg","image/png"];

    if(!in_array($tip,$dozvoljeniTipovi))
        return "Dozvoljeni su JPG i PNG.";

    if($velicina > 5*1024*1024)
        return "Slika je veća od 5MB.";

    return null;
}




?>
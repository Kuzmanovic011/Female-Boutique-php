<?php 
session_start();

if(isset($_POST["dodajUKorpu"])) {

    $id = $_POST["idArtikla"];
    $naziv = $_POST["nazivArtikla"]; 
    $cena = $_POST["cenaArtikla"]; 
    $velicina = $_POST["velicinaA"];

    $dozvoljeneVelicine = ["XS","S","M","L","XL"];

    if(!in_array($velicina,$dozvoljeneVelicine)){
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    if(!isset($_SESSION["korpa"])){
        $_SESSION["korpa"] = [];
    }

    /*
     kljuc => idArtikla + velicinaArtikla
    */

    $kljuc = $id."_".$velicina;

    if(isset($_SESSION["korpa"][$kljuc])){ /*ukoliko u korpi vec postoji takav artikal, isti id i velicina, uvecava se samo kolicina*/
        $_SESSION["korpa"][$kljuc]["kolicina"]++;
    }
    else{
        $_SESSION["korpa"][$kljuc] = [ /*kljuc predstavlja kombinaciju kljuca i velicine npr. 5_XL*/
            "naziv" => $naziv,
            "cena" => $cena,
            "velicina" => $velicina,
            "kolicina" => 1
        ];
    }

}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?> 
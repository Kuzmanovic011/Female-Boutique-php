<?php
session_start();
require_once "konekcija.php";
if(isset($_SESSION["id"]))
    $idKorisnika = $_SESSION["id"];

if(isset($_SESSION["korpa"]) && count($_SESSION["korpa"]) > 0){

   $kolicinaArtikala = [];

// sabiranje količina po artiklu
foreach($_SESSION["korpa"] as $kljuc => $stavka){

    $idArtikla = substr($kljuc, 0, strpos($kljuc, "_"));

    if(!isset($kolicinaArtikala[$idArtikla])){
        $kolicinaArtikala[$idArtikla] = 0;
    }

    $kolicinaArtikala[$idArtikla] += $stavka["kolicina"];
}

// provera stanja u bazi
foreach($kolicinaArtikala as $idArtikla => $ukupno){

    $upit = "SELECT kolicinaArtikla 
             FROM artikli 
             WHERE idArtikla=$idArtikla";

    $rez = mysqli_query($dbc,$upit);
    $red = mysqli_fetch_assoc($rez);

    if($ukupno > $red["kolicinaArtikla"]){
        $poruka = "Greška: pokušavate da poručite $ukupno komada, a na stanju ima samo ".$red["kolicinaArtikla"];
        $_SESSION["porudzbinaGreska"] = $poruka;
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
}
    foreach($_SESSION["korpa"] as $kljuc => $stavka){
        // Delimo ključ da dobijemo ID artikla
        $idArtikla = substr($kljuc, 0, strpos($kljuc, "_"));
        if(!isset($kolicinaArtikala[$idArtikla])) {
            $kolicinaArtikala[$idArtikla] = 0;
        }
        $kolicinaArtikala[$idArtikla]+=$stavka["kolicina"];

        $velicinaKorpa = $stavka["velicina"];  
        $kolicinaKorpa = $stavka["kolicina"];  

        $napomena = mysqli_real_escape_string($dbc, $_POST["napomena"] ?? "nema");
        // Provera stanja u bazi
        $upit = "SELECT * 
                 FROM artikli
                 WHERE idArtikla = $idArtikla 
                 AND kolicinaArtikla > 0";
        $rezultat = mysqli_query($dbc, $upit);

        if(mysqli_num_rows($rezultat) > 0){
            $red = mysqli_fetch_assoc($rezultat);

            // Možeš dodatno proveriti da li je tražena količina dostupna
            $kolicinaNaStanju = $red["kolicinaArtikla"];
            if($kolicinaKorpa <= $kolicinaNaStanju){
                echo "<strong>Artikal na stanju:</strong><br>";
                echo "Naziv: " . $stavka["naziv"] . "<br>";
                echo "Cena: " . $stavka["cena"] . "<br>";
                echo "Veličina: " . $velicinaKorpa . "<br>";
                echo "Količina u korpi: " . $kolicinaKorpa . "<br>";
                echo "Na stanju: " . $kolicinaNaStanju . "<br>";
                echo "<hr>";
                $datumIsporuke= date("Y-m-d", strtotime("+3 days"));
               $upit1 = "INSERT INTO porudzbine 
                        (idKorisnika, idArtikla, velicinaArtikla, datumIsporuke, napomena)
                        VALUES (
                            '$idKorisnika',
                            '$idArtikla',
                            '$velicinaKorpa',
                            '$datumIsporuke',
                            '$napomena'
                        )";
                $upit2 = "UPDATE artikli 
                          SET kolicinaArtikla = kolicinaArtikla - $kolicinaKorpa
                WHERE idArtikla = $idArtikla
                AND kolicinaArtikla >= $kolicinaKorpa";
                $rez2 = mysqli_query($dbc, $upit2);
                    if(!$rez2){
                        $_SESSION["porudzbinaGreska"] =
                        "Greška pri ažuriranju stanja artikla. Porudžbina nije realizovana.";
                        header("Location: ".$_SERVER['HTTP_REFERER']);
                        exit();
                    }
                $rez1= mysqli_query($dbc, $upit1);
                if(!$rez1){
                    $_SESSION["porudzbinaGreska"] =
                    "Greška pri upisu porudžbine u bazu podataka.";
                    header("Location: ".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            
                /*upis u datoteku*/
                    $folder = "Porudzbine"; // ime foldera

                    if (!is_dir($folder)) {
                        mkdir($folder, 0777, true);
                    }
                    
                    $sql = "SELECT ime, prezime, adresa, brojTelefona 
                            FROM korisnici 
                            WHERE idKorisnika=$idKorisnika";
                    $rez = mysqli_query($dbc, $sql);
                    if(!$rez) {
                                $_SESSION["porudzbinaGreska"] =
                                "Greška pri ucitavanju korisnika iz baze.";
                                header("Location: ".$_SERVER['HTTP_REFERER']);
                                exit();
                    }
                    $redPodataka = mysqli_fetch_assoc($rez); 
                    $datumVreme = date("Y-m-d H:i:s");
                    $brojNarudzbine = count(glob($folder."/Porudzbina_".$idKorisnika."_*.txt")) + 1;
                    $imeFajla =$folder."/Porudzbina_".$idKorisnika."_".$brojNarudzbine."_".date("Ymd_His").".txt";
                    $fh = fopen($imeFajla, "a");
                    if($fh===false)
                        die("Neuspesno otvaranje datoteke!");
                
                    $podaci = "\nDatum i vreme kreiranja porudžbine: ".$datumVreme."\nIme: ".$redPodataka['ime']."\nPrezime: ".$redPodataka['prezime'].
                    "\nAdresa: ".$redPodataka['adresa']."\nBroj Telefona: ".$redPodataka['brojTelefona']."\n";
                    $podaci2 = "Artikal: ".$stavka["naziv"]."\nCena: ".$stavka["cena"]."\nDatum isporuke: ".$datumIsporuke.
                    "\nKoličina: ".$kolicinaKorpa."\nVeličina: ".$velicinaKorpa."\n";

                    $redTekstaZaUpis = $podaci.$podaci2;
                    fwrite($fh, $redTekstaZaUpis);
                    fclose($fh);

                $_SESSION["kupovinaUspesno"] = "Vaša poruždbina je evidentirana i dostupna na vašem profilu.";
                header("Location: index.php");
                exit();
            }
        } else {
            echo "<strong>Artikal više nije na stanju:</strong> " . $stavka["naziv"] . "<br><hr>";
        }
    }
      unset($_SESSION["korpa"]);

} else {
    echo "Korpa je prazna.";
}



?>
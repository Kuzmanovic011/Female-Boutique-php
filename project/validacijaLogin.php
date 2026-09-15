<?php
session_start();
header("Content-Type: application/json");
require_once "konekcija.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
  header("Location: login.php");
  exit();
} 

$greskeLogin = [];
$greskeRegistracija = [];

/* ================= LOGIN ================= */

    if(isset($_POST["mailLogin"])){

    $mail = trim($_POST["mailLogin"] ?? "");
    $lozinka = trim($_POST["lozinkaLogin"] ?? "");
    $hashLozinka = "";
    if(empty($mail) || empty($lozinka)){
        $greskeLogin[] = "Popunite sva polja.";
    }

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $greskeLogin[] = "Unesite ispravnu email adresu.";
    }

    if(empty($greskeLogin)){

        $upit = "SELECT idKorisnika, ime, prezime, tipKorisnika, lozinka
                 FROM korisnici
                 WHERE email = ?";

        $stmt = mysqli_prepare($dbc,$upit);

        mysqli_stmt_bind_param($stmt,"s",$mail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) === 1){

            mysqli_stmt_bind_result(
                $stmt,
                $id,
                $ime,
                $prezime,
                $tip,
                $hashLozinka
            );

            mysqli_stmt_fetch($stmt);

            if(password_verify($lozinka,$hashLozinka)){

                session_regenerate_id(true);

                $_SESSION["id"] = $id;
                $_SESSION["ime"] = $ime;
                $_SESSION["prezime"] = $prezime;
                $_SESSION["tipKorisnika"] = $tip;

                mysqli_stmt_close($stmt);

                /* broj pristupa */
                $update = mysqli_prepare($dbc,
                    "UPDATE korisnici SET brojPristupa = brojPristupa + 1 WHERE idKorisnika=?"
                );

                mysqli_stmt_bind_param($update,"i",$id);
                mysqli_stmt_execute($update);
                mysqli_stmt_close($update);
                
                $sadrzajKolacica = $_SESSION["ime"]." ".$_SESSION["prezime"];
            
                $_SESSION["loginUspesno"] = "Uspešno ste logovani!";
                setcookie("login", $sadrzajKolacica, time() + 3600, "/");
                echo json_encode([
                        "status"=>"ok"
                    ]);
                    exit();
            }
        }
            $greskeLogin[] = "Pogrešan email ili lozinka.";
            mysqli_stmt_close($stmt);
    } else {

            $_SESSION["loginGreske"] = $greskeLogin;
            echo json_encode([
            "status"=>"error",
            "greske"=>$greskeLogin
                ]);
                exit();
      }
}


/* ================= REGISTRACIJA ================= */

else if(isset($_POST["btnRegistracija"])){

    $ime = trim($_POST["registracijaIme"] ?? "");
    $prezime = trim($_POST["registracijaPrezime"] ?? "");
    $mail = trim($_POST["registracijaMail"] ?? "");
    $lozinka = trim($_POST["registracijaLozinka"] ?? "");
    $lozinka2 = trim($_POST["registracijaLozinka1"] ?? "");
    $telefon = trim($_POST["registracijaTelefon"] ?? "");
    $adresa = trim($_POST["registracijaAdresa"] ?? "");

    if(empty($ime) || empty($prezime) || empty($mail) ||
       empty($lozinka) || empty($lozinka2) ||
       empty($telefon) || empty($adresa) ||
       !isset($_POST["registracijaUslovi"])){

        $greskeRegistracija[] = "Popunite sva polja i prihvatite uslove.";
    }

    if(!proveraImePrezime($ime) || !proveraImePrezime($prezime)){
        $greskeRegistracija[] = "Ime i prezime nisu u ispravnom formatu.";
    }

    if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        $greskeRegistracija[] = "Email nije ispravan.";
    }

    if(!proveraLozinke($lozinka)){
        $greskeRegistracija[] =
        "Lozinka mora imati 8+ karaktera, veliko slovo, broj i specijalan znak.";
    }

    if(strcmp($lozinka,$lozinka2)!==0){
        $greskeRegistracija[] = "Lozinke nisu identične.";
    }

    if(!proveraTelefon($telefon)){
        $greskeRegistracija[] = "Broj telefona nije ispravan.";
    }

    if(!proveraAdresa($adresa)){
        $greskeRegistracija[] = "Adresa nije u ispravnom formatu.";
    }

    if(!proveraMailTelefon($dbc,$mail,$telefon)){
        $greskeRegistracija[] = "Korisnik sa ovim podacima već postoji.";
    }

    //provera gresaka
    if(!empty($greskeRegistracija)){
        $_SESSION["registracijaGreske"] = $greskeRegistracija;
        header("Location: login.php");
        exit();
    }

    $upload = proveraDatoteka();
    if($upload !== null){
        $_SESSION["registracijaGreske"][] = $upload;
        header("Location: login.php");
        exit();
    }

    $slika = $_FILES["registracijaDatoteka"]["name"];
    move_uploaded_file(
        $_FILES["registracijaDatoteka"]["tmp_name"],
        "datoteke/".basename($slika)
    );

    /* INSERT */

    $hashLozinka = password_hash($lozinka,PASSWORD_DEFAULT);

    $upit = "INSERT INTO korisnici
    (ime,prezime,email,lozinka,tipKorisnika,adresa,brojTelefona,slikaKorisnika)
    VALUES (?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($dbc,$upit);

    $tip = "Korisnik";

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $ime,$prezime,$mail,$hashLozinka,
        $tip,$adresa,$telefon,$slika
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION["registracijaUspesno"] = "Registracija uspešna!";
    header("Location: login.php");
    exit();
}



//korisnicki definisane funkcije, dodatne provere
function proveraLozinke($lozinka){

    if(strlen($lozinka) < 8) return false;
    if(!ctype_alpha($lozinka[0])) return false;
    if(!preg_match('/[A-Z]/',$lozinka)) return false;
    if(!preg_match('/[0-9]/',$lozinka)) return false;
    if(!preg_match('/[^a-zA-Z0-9]/',$lozinka)) return false;

    return true;
}

function proveraImePrezime($s){
    return preg_match('/^\p{L}+$/u',$s);
}

function proveraTelefon($t){
    return strlen($t)>=9 && ctype_digit($t) && $t[0]=="0";
}

function proveraAdresa($a){
    return strlen($a)>=5;
}

function proveraMailTelefon($dbc,$mail,$tel){

    $stmt = mysqli_prepare($dbc,
        "SELECT idKorisnika FROM korisnici WHERE email=? OR brojTelefona=?"
    );

    mysqli_stmt_bind_param($stmt,"ss",$mail,$tel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    return mysqli_stmt_num_rows($stmt) === 0;
}

function proveraDatoteka(){

    if(!isset($_FILES["registracijaDatoteka"]))
        return "Niste uneli sliku.";

    if($_FILES["registracijaDatoteka"]["error"] !== UPLOAD_ERR_OK)
        return "Greška pri uploadu.";

    $tipDat = $_FILES["registracijaDatoteka"]["type"];
    $velicinaDat = $_FILES["registracijaDatoteka"]["size"];

    $dozvoljeniTipovi = ["image/jpeg","image/png"];

    if(!in_array($tipDat, $dozvoljeniTipovi))
        return "Dozvoljeni su JPG i PNG.";

    if($velicinaDat > 5*1024*1024)
        return "Slika je veća od 5MB.";

    return null;
}
<?php 
session_start();
$citati = [
    "Moda prolazi, stil ostaje. - Coco Chanel",
    "Obuci se kao da ćeš danas sresti svog najvećeg neprijatelja. - Coco Chanel",
    "Elegancija nije u tome da se primeti, već da se pamti. - Giorgio Armani",
    "Stil je način da kažeš ko si, bez da progovoriš.",
    "Luksuz mora biti udoban, inače nije luksuz. - Coco Chanel",
    "Ne prati modu — stvori je.",
    "Jednostavnost je vrhunska sofisticiranost. - Leonardo da Vinci"
];
$randomIndex = array_rand($citati);
$randomCitat = $citati[$randomIndex];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nama</title>
    <link rel="icon" type="image/png" href="slike/Logo_ZOMI.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="stil.css">
<body> 
<div class="container-fluid">
<!--NAVIGACIJA-->    
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0 border-bottom border-danger-subtle border-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img id="imgNavBrand" src="slike/Logo_ZOMI.jpeg" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-left">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php" id="tekst">Početna stranica</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="onama.php">O nama</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="promocija.php">Aktuelna promocija</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Prodavnica
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="majice.php">Majice</a></li>
            <li><a class="dropdown-item" href="farmerke.php">Farmerke</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="dzemperi.php">Džemperi</a></li>
            <li><a class="dropdown-item" href="kaputi.php">Kaputi</a></li>
            <li><a class="dropdown-item" href="haljine.php">Haljine</a></li>
            <li><a class="dropdown-item" href="kompleti.php">Kompleti</a></li>
          </ul>
        </li>
      </ul> 
         <ul class="navbar-nav ms-auto align-items-center">
          <?php if(!isset($_SESSION["id"])): ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fa-regular fa-user"></i> Prijava
                </a>
            </li>
          <?php else: ?>
          <?php if($_SESSION["tipKorisnika"] === "Korisnik"): ?> <!--u koliko je tip korisnika Korisnik-->
            <li class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 w-100" id="meniKorpa">
<?php
  if(isset($_SESSION["korpa"]) && count($_SESSION["korpa"]) > 0) {
    $ukupno = 0;
    $brStvari = 0;
    foreach($_SESSION["korpa"] as $id => $stavka){ //kljuc => vrednost
   //prolaz kroz niz artikala i ispis stavki korpe 
      $brStvari++;
      echo "<li class='mb-2'>";
      echo "<strong>Artikal $brStvari:</strong> ".$stavka["naziv"]."<br>";
      echo "(".$stavka["kolicina"]."x)<br>";
      echo "Cena: ".$stavka["cena"]."<br>";
      echo "Veličina: ".$stavka["velicina"]." ";
      echo "<a href='obrisiStavkuKorpe.php?id=".$id."' class='text-danger ms-2'>X</a>"; 
      echo "</li>";
      $ukupno += $stavka["cena"] * $stavka["kolicina"];
}
      echo "<hr>";
      echo "<li><b>Ukupno: ".$ukupno." RSD</b></li>";
      echo "<li class='mt-2'>";
      echo '<button class="btn btn-info w-100 mb-2"
              data-bs-toggle="modal"
              data-bs-target="#porudzbinaModal">
              <i class="fa-solid fa-dolly"></i> Poruči
              </button>';
      echo "<a href='obrisiKorpu.php' class='btn btn-danger w-100'>";
      echo "<i class='fa fa-trash'></i> Isprazni korpu";
      echo "</a>";
      echo "</li>";
}
else{
    echo "<li>Korpa je prazna</li>";
}
?>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
              <span class="nav-link fw-semibold">
                <a  href="korisnikPanel.php"><i class="fa-regular fa-user"></i></a>
                <?php echo $_SESSION["ime"]; ?>
                </span>                    
            </li>
           <?php elseif($_SESSION["tipKorisnika"] === "Administrator"): ?>
            <li class="nav-item">
              <span class="nav-link fw-semibold">
                <a  href="adminPanel.php"><i class="fa-solid fa-user-shield"></i></a>
                <?php echo $_SESSION["ime"]; ?>
                </span>                    
            </li>
           <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link text-danger" href="odjava.php">
                    Odjava
                </a>
            </li>
        <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>
<!--NAVGIJACIJA-->

   <!--SADRZAJ STRANICE-->
<div class="container py-5">
<h3 class="display-4 text-center mb-5 fw-bold">
  Saznajte više o nama!
</h3>
<div class="row g-5 align-items-center">
  <div class="col-lg-6">
      <div class="p-4 shadow-sm rounded" style="background-color:pink;">
          
          <p class="lead">
              Započeli smo sa radom u januaru 2019. godine, bavimo se prodajom isključivo ženske garderobe 
              turskog ili italijanskog porekla, visokog kvaliteta, pristupačne cene za svakoga. 
          </p>

          <p>
              Idealan izbor garderobe za poklon dragoj, voljenoj osobi. Na raspolaganju smo vam za svaku pomoć 
              pri odabiru savršenog komada garderobe, veličine, boje i kolekcije.
          </p>

          <p>
              Mogućnost dolaska na našu adresu uz prethodni dogovor. Nudimo i naručivanje garderobe po vašem izboru 
              ako postoji na stanju.
          </p>

          <blockquote class="blockquote mt-4">
              <p class="mb-0">
                  <i><?php echo $randomCitat; ?></i>
              </p>
              <footer class="blockquote-footer mt-2">
                  <strong>Citat dana</strong> - inspiracija za svaki dan
              </footer>
          </blockquote>
      </div>
  </div>

  <div class="col-lg-6 text-center">
  <img src="slike/Logo_ZOMI.jpeg" class="img-fluid mb-4" style="max-width:220px" alt="Logo">
    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Da li mogu da kupim garderobu preko sajta?
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Naša garderoba dostupna je <strong> kako online tako i uživo.</strong> Posetite nas na adresi <i> Vojvode Stepe 283</i>, gde vas čeka širok izbor stilova i personalizovana pomoć našeg tima.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Koje je radno vreme?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <strong>  Svakog radnog dana</strong> radimo <strong> od 8h do 16h</strong>, <strong>subotom</strong> radimo skraćeno <strong> od 8h do 14h.</strong>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Koje su opcije plaćanja dostupne?
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            U našem butiku možete platiti  <strong>gotovinom ili platnim karticama (uplatom na račun).</strong> </div>
        </div>
      </div>
      <div class="accordion-item">
          <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              Šta ako mi ne odgovara veličina ili model?
            </button>
          </h2>
          <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              U butiku možete isprobati različite veličine i modele uz pomoć našeg stručnog osoblja kako biste pronašli savršeni komad. <strong> Ne vraćamo isprobanu garderobu.</strong>
          </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              Kako mogu da saznam da li je određeni proizvod dostupan?
            </button>
          </h2>
          <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              Možete nas kontaktirati putem <strong> telefona, e-pošte ili društvenih mreža</strong> kako biste proverili dostupnost određenog proizvoda u butiku.
            </div>
          </div>
        </div>
    </div>  
</div>
</div>
</div>
<!--SADRZAJ STRANICE-->

<!--footer-->
  <footer class="container-fluid border-danger-subtle border-top border-3">
      <div class="row align-items-start">
        <div class="col p-3 text-center">
            <h3 class="border-bottom border-danger-subtle"><em class="blockquote-footer"><i class="fa-solid fa-copyright"></i>Sva prava zadržana</em></h3>
            <p class="mt-4">
              <em>Zomi Garderoba - Mesto gde moda postaje vaš saveznik u svakodnevnom izražavanju stila i 
                  elegancije. Svaki komad pažljivo biramo kako bi se uklopio u vaš ritam i istakao vašu jedinstvenost.
              </em>
            </p>
        </div>
        <div class="col p-3 text-center">
              <h3 class="border-bottom border-danger-subtle">Posetite nas</h3>
              <p class="mt-4">
               <a class="nav-link" href="https://www.instagram.com/zomi_garderoba/" target="_blank"><i class="fa-brands fa-2x fa-instagram"></i></a>
               <a class="nav-link mt-2" href="https://www.facebook.com/profile.php?id=100063623911466&locale=sr_RS" target="_blank"><i class="fa-brands fa-2x fa-facebook"></i></a>
              </p>
        </div>
        <div class="col p-3 text-center">
            <h3 class="border-bottom border-danger-subtle"><i class="fa-solid fa-square-phone"></i>KONTAKT</h3>
            <div class="mt-4">
              <i class="fas fa-home me-2 p-2"></i>Vojvode Stepe 283 <br>
              <i class="fas fa-envelope me-2 p-2"></i> info@zomi_garderoba.com<br>
              <i class="fas fa-phone me-2 p-2"></i>+381 64/5266-774<br>
              <i class="fas fa-phone me-2 p-2"></i>011/2324-995<br>
            </div>
        </div>
      </div>
  </footer>
<!--footer-->
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
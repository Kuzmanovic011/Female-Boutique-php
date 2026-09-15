<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna stranica</title>
    <link rel="icon" type="image/png" href="slike/Logo_ZOMI.jpeg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="stil.css">
</head>    
<body> 
    <?php if(isset($_SESSION["kupovinaUspesno"])): ?> <!--obavestenje o uspesnoj kupovini-->
<div class="modal fade" id="kupovinaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Obaveštenje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php 
            echo $_SESSION["kupovinaUspesno"]; 
            unset($_SESSION["kupovinaUspesno"]);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">U redu</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var loginModal = new bootstrap.Modal(document.getElementById('kupovinaModal'));
    loginModal.show();
});
</script>
<?php endif; ?>

  <?php if(isset($_SESSION["loginUspesno"])): ?> <!--obavestenje o uspesnom logovanju-->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Obaveštenje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php 
            echo $_SESSION["loginUspesno"]; 
            echo $_SESSION["ime"];
            echo $_SESSION["prezime"];
            unset($_SESSION["loginUspesno"]);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">U redu</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
});
</script>
<?php endif; ?>
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
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="index.php" id="tekst">Početna stranica</a>
        </li>
        <li class="nav-item">
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
<div class="container-fluid pb-2">
  <div class="row">
    <div class="col">
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="slike/slajderSlika1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h4 class="display-4 d-inline-block">Vaš stil, Vaša priča</h4>
      </div>
    </div>
    <div class="carousel-item">
      <img src="slike/slajderSlika2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
         <h4 class="display-4 d-inline-block">Moda za svaki trenutak</h4>
      </div>
    </div>
    <div class="carousel-item">
      <img src="slike/slajderSlika3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h4 class="display-4 d-inline-block">Nova kolekcija je stigla!</h4>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>
  </div>

  <div class="row justify-content-center align-items-stretch">
   <div class="text-center my-5">
  <h2 class="display-4 fw-bold text-light">ZOMI GARDEROBA</h2>
  <p class="text-light opacity-75 fs-2">Moda koja prati vaš stil</p>
  <hr class="border-danger border-3 w-25 mx-auto opacity-100">
</div>
<div class="col-md-4 d-flex justify-content-center mb-4">
  <div class="card h-100 d-flex flex-column" style="width: 18rem;">
    <img src="slike/pocetna3.jpeg"
         class="card-img-top img-fluid img-thumbnail" alt="">
    <div class="card-body d-flex flex-column flex-grow-1 text-center">
      <h5 class="card-title fw-semibold text-white mb-3">
       Naša ponuda kaputa
      </h5>
      <p class="card-text text-white opacity-75 lh-lg mb-4">
        Pogledajte naš prelep izbor kaputa koji spajaju stil i udobnost.
        Savršeni za hladnije dane, ali i za elegantan svakodnevni izgled.
        Istaknite svoju eleganciju uz moderne krojeve i pažljivo odabrane detalje.
        Pronađite kaput koji će upotpuniti vaš stil u našoj kolekciji.
      </p>
    </div>
    <div class="card-body text-center mt-auto">
           <a class="btn btn-light" href="kaputi.php"><i class="fa-solid fa-arrow-pointer"></i>Pogledajte ponudu</a>
    </div>
  </div>
</div>
<div class="col-md-4 d-flex justify-content-center mb-4">
  <div class="card h-100 d-flex flex-column" style="width: 18rem;">
    <img src="slike/pocetna1.jpg" class="card-img-top img-fluid img-thumbnail"alt="">
    <div class="card-body d-flex flex-column flex-grow-1 text-center">
      <h5 class="card-title fw-semibold text-white mb-3">
         Naša ponuda haljina
      </h5>
      <p class="card-text text-white opacity-75 lh-lg mb-4">
        Pogledajte naš prelep izbor haljina koje spajaju eleganciju i udobnost.
        Savršene za posebne trenutke, ali i za svakodnevni stil.
        Istaknite svoju ženstvenost uz moderne krojeve i pažljivo odabrane detalje.
        Pronađite haljinu koja će istaći vaš stil u našoj kolekciji.
    </p>
    </div>
    <div class="card-body text-center mt-auto">
           <a class="btn btn-light" href="haljine.php"><i class="fa-solid fa-arrow-pointer"></i>Pogledajte ponudu</a>
    </div>
  </div>
</div>
<div class="col-md-4 d-flex justify-content-center mb-4">
  <div class="card h-100 d-flex flex-column" style="width: 18rem;">
    <img src="slike/pocetna2.jpg" class="card-img-top img-fluid img-thumbnail" alt="">
    <div class="card-body d-flex flex-column flex-grow-1 text-center">
      <h5 class="card-title fw-semibold text-white mb-3">
        Naša ponuda kompleta
      </h5>
      <p class="card-text text-white opacity-75 lh-lg mb-4">
        Pogledajte naš prelep izbor kompleta koji spajaju stil i udobnost.
        Savršeni za različite prilike, ali i za moderan svakodnevni izgled.
        Istaknite svoju eleganciju uz moderne krojeve i pažljivo odabrane detalje.
        Pronađite komplet koji će upotpuniti vaš stil u našoj kolekciji.
      </p>
    </div>
    <div class="card-body text-center mt-auto">
     <a class="btn btn-light" href="kompleti.php"><i class="fa-solid fa-arrow-pointer"></i>Pogledajte ponudu</a>
    </div>
  </div>
</div>
  </div>
</div>

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
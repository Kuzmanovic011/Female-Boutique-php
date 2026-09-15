<?php 
session_start();
require_once "konekcija.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZOMI Džemperi</title>
    <link rel="icon" type="image/png" href="slike/Logo_ZOMI.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">
     <link rel="stylesheet" href="stil.css" type="text/css">
</head>    
<body> 
  <div class="container-fluid">
<!--NAVIGACIJA-->    
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0 border-bottom border-danger-subtle border-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img id="imgNavBrand" src="slike/Logo_ZOMI.jpeg" alt="slika_nije_dostupna">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-left">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php" id="tekst">Početna stranica</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="onama.php">O nama</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="promocija.php">Aktuelna promocija</a>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Prodavnica
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="majice.php">Majice</a></li>
            <li><a class="dropdown-item" href="farmerke.php">Farmerke</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item active" href="dzemperi.php">Džemperi</a></li>
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
          <?php if($_SESSION["tipKorisnika"] === "Korisnik"): ?> <!--ukoliko je tip korisnika Korisnik-->
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
<div class="container pb-5">
        <div class="container pb-5">
        <div class="text-center my-5">
              <h2 class="display-4 fw-bold text-light">Džemperi</h2>
              <hr class="border-danger border-3 w-25 mx-auto opacity-100">
        </div>     
<?php 
  $upit = "SELECT * 
           FROM artikli
           WHERE tipArtikla = 'DZEMPER' AND kolicinaArtikla>0";
  $rezultat = mysqli_query($dbc,$upit);
  if(mysqli_num_rows($rezultat) > 0) {
      $brojacKartica = 0;
?>
    <div class="row justify-content-center">
<?php 
  while($red = mysqli_fetch_assoc($rezultat)) { 
?>
    <div class="col-md-4 d-flex justify-content-center mb-4">
        <div class="card" style="width: 18rem;">
            <img src="slike/<?php echo $red['slikaArtikla']; ?>"
                 class="card-img-top"
                 alt="<?php echo $red['nazivArtikla']." slika"; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo "Naziv artikla ~ ".$red["nazivArtikla"]; ?></h5>
              <p class="card-text"><?php echo "Cena artikla ~ <i>".$red["cenaArtikla"]." RSD</i>";?></p>
              <form method="POST" action="dodajUKorpu.php">
                <input type="hidden" name="idArtikla" value=<?php echo $red["idArtikla"];?>>
                <input type="hidden" name="nazivArtikla" value=<?php echo $red["nazivArtikla"];?>>
                <input type="hidden" name="cenaArtikla" value=<?php echo $red["cenaArtikla"];?>>
                <select name="velicinaA" class="custom-select mb-3">
                  <option value="">Odaberite veličinu</option>
                  <option value="XS">XS</option>
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                </select>    
                <?php if(isset($_SESSION["tipKorisnika"]) && $_SESSION["tipKorisnika"] === "Korisnik"): ?>
                    <button type="submit" name="dodajUKorpu" class="btn btn-dark mx-auto d-block">Dodaj u korpu</button>
                <?php endif; ?>
              </form>
            </div>     
        </div>
    </div>
<?php
  $brojacKartica++;
  if($brojacKartica % 3 == 0){
      echo '</div><div class="row justify-content-center">';
  }} 
?>
    </div>
<?php
  }
  else{
?>
    <h3 class="display-3 text-center">
        Nema artikala na stanju!
    </h3>
<?php } 
?>
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
<!-- MODAL PORUDZBINA -->
<div class="modal fade" id="porudzbinaModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Potvrda porudžbine</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="poruci.php">
        <div class="modal-body">
          <label>Napomena:</label>
          <textarea name="napomena" class="form-control" placeholder="Unesite napomenu..."></textarea>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
          <button type="submit" name="potvrdiPorudzbinu" class="btn btn-success"> Potvrdi porudžbinu</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
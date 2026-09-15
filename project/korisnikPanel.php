<?php
session_start();
require_once "konekcija.php";
$id = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel <?php echo $_SESSION["ime"] . " " . $_SESSION["prezime"]; ?></title>
  <link rel="icon" type="image/png" href="slike/Logo_ZOMI.jpeg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="stil.css">
</head>
<body>
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
            <li class="nav-item active">
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
  <div class="container text-center mt-5">
    <?php
    $stmt = mysqli_prepare(
      $dbc,
      "SELECT slikaKorisnika FROM korisnici WHERE idKorisnika=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $slika);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    ?>
    <div class="d-flex align-items-center justify-content-center gap-4">

      <?php if (!empty($slika)): ?>
        <img src="datoteke/<?php echo $slika; ?>"
          class="img-thumbnail rounded-circle"
          width="200">
      <?php endif; ?>
      <h4 class="display-5 mb-0">
        Dobrodošli <?php echo $_SESSION["ime"] . " " . $_SESSION["prezime"]; ?> !
      </h4>
    </div>
    <div class="text-center my-5">
      <h2 class="display-4 fw-bold text-light">Pregled poružbina</h2>
      <hr class="border-danger border-3 w-25 mx-auto opacity-100">
    </div>
    <?php

    $idKorisnika = $_SESSION["id"];
    $datoteke = glob("Porudzbine/*.txt");

    $brojac = 0;

    echo '<div class="accordion mt-5" id="porudzbineAccordion">';

    foreach ($datoteke as $dat) {

      $imeDat = basename($dat);

      /* Filtriraj samo porudzbine tog korisnika */
      if (strpos($imeDat, "Porudzbina_" . $idKorisnika . "_") !== false) {

        $brojac++;

        $sadrzajDatoteke = file($dat, FILE_IGNORE_NEW_LINES);

    ?>

        <div class="accordion-item">

          <h2 class="accordion-header">

            <button class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#porudzbina<?php echo $brojac; ?>">

              <?php

              $nazivBezExt = pathinfo($imeDat, PATHINFO_FILENAME);

              /* Uzmi deo do trece donje crte */
              $delovi = explode("_", $nazivBezExt);
              $prikazNaziv = $delovi[0] . "_" . $delovi[1] . "_" . $delovi[2];

              ?>

               <?php echo htmlspecialchars($prikazNaziv); ?>

            </button>

          </h2>

          <div id="porudzbina<?php echo $brojac; ?>"
            class="accordion-collapse collapse"
            data-bs-parent="#porudzbineAccordion">

            <div class="accordion-body text-start">

              <?php
              /* Čitaj od 7. linije */
              for ($i = 6; $i < count($sadrzajDatoteke); $i++) {
                echo htmlspecialchars($sadrzajDatoteke[$i]) . "<br>";
              }
              ?>

            </div>

          </div>

        </div>

    <?php
      }
    }

    echo '</div>';
    ?>
    <br><br>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>
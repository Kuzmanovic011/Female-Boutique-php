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
  <?php if (isset($_SESSION["uspesnoAdmin"])): ?>
    <div class="modal fade" id="adminUspesnoModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Obaveštenje</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <?php
            echo $_SESSION["uspesnoAdmin"];
            // echo "Uspesna izmena!";
            unset($_SESSION["uspesnoAdmin"]);
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
        var loginModal = new bootstrap.Modal(document.getElementById('adminUspesnoModal'));
        loginModal.show();
      });
    </script>
  <?php endif; ?>
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
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="dzemperi.php">Džemperi</a></li>
              <li><a class="dropdown-item" href="kaputi.php">Kaputi</a></li>
              <li><a class="dropdown-item" href="haljine.php">Haljine</a></li>
              <li><a class="dropdown-item" href="kompleti.php">Kompleti</a></li>
            </ul>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center">
          <?php if (!isset($_SESSION["id"])): ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">
                <i class="fa-regular fa-user"></i> Prijava
              </a>
            </li>
          <?php else: ?>
            <?php if ($_SESSION["tipKorisnika"] === "Korisnik"): ?> <!--u koliko je tip korisnika Korisnik-->
              <li class="nav-item">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-basket-shopping"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end mt-2 w-100" id="meniKorpa">
                    <?php
                    if (isset($_SESSION["korpa"]) && count($_SESSION["korpa"]) > 0) {
                      $ukupno = 0;
                      $brStvari = 0;
                      foreach ($_SESSION["korpa"] as $id => $stavka) { //kljuc => vrednost
                        //prolaz kroz niz artikala i ispis stavki korpe 
                        $brStvari++;
                        echo "<li class='mb-2'>";
                        echo "<strong>Artikal $brStvari:</strong> " . $stavka["naziv"] . "<br>";
                        echo "(" . $stavka["kolicina"] . "x)<br>";
                        echo "Cena: " . $stavka["cena"] . "<br>";
                        echo "Veličina: " . $stavka["velicina"] . " ";
                        echo "<a href='obrisiStavkuKorpe.php?id=" . $id . "' class='text-danger ms-2'>X</a>";
                        echo "</li>";
                        $ukupno += $stavka["cena"] * $stavka["kolicina"];
                      }
                      echo "<hr>";
                      echo "<li><b>Ukupno: " . $ukupno . " RSD</b></li>";
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
                    } else {
                      echo "<li>Korpa je prazna</li>";
                    }
                    ?>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <span class="nav-link fw-semibold">
                  <a href="korisnikPanel.php"><i class="fa-regular fa-user"></i></a>
                  <?php echo $_SESSION["ime"]; ?>
                </span>
              </li>
            <?php elseif ($_SESSION["tipKorisnika"] === "Administrator"): ?>
              <li class="nav-item active">
                <span class="nav-link fw-semibold">
                  <a href="adminPanel.php"><i class="fa-solid fa-user-shield"></i></a>
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
  <div class="container-fluid">
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
      <div class="container mt-5">

        <div class="container mt-4">
          <div class="row g-4">

            <!-- PRVA KOLONA -->
            <div class="col-lg-4">

              <div class="card shadow h-100 border-0">
                <div class="card-body">

                  <h4 class="text-center mb-4">Dodavanje artikla</h4>

                  <form action="adminDodavanje.php" method="POST" enctype="multipart/form-data" class="needs-validation">

                    <div class="mb-3">
                      <label class="form-label">Naziv proizvoda</label>
                      <input name="nazivProizvoda" type="text" class="form-control" placeholder="Unesite ime proizvoda..." required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Tip proizvoda</label>
                      <select name="tipProizvoda" class="form-select custom-select mb-3" required>
                        <option selected disabled>Izaberite tip proizvoda</option>
                        <option value="MAJICA">Majica</option>
                        <option value="FARMERKE">Farmerke</option>
                        <option value="DZEMPER">Džemper</option>
                        <option value="KAPUT">Kaput</option>
                        <option value="HALJINA">Haljina</option>
                        <option value="KOMPLET">Komplet</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Količina proizvoda</label>
                      <input name="kolicinaProizvoda" type="number" class="form-control" placeholder="Unesite količinu proizvoda..." required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Cena proizvoda</label>
                      <input name="cenaProizvoda" type="number" class="form-control" placeholder="Unesite cenu proizvoda..." required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Opis proizvoda</label>
                      <textarea name="opisProizvoda" class="form-control" rows="3" style="resize:none;" placeholder="Unesite opis proizvoda (opciono)..."></textarea>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Fotografija proizvoda</label>
                      <input name="fotografijaProizvoda" type="file" class="form-control" required>
                    </div>

                    <div class="d-grid">
                      <button class="btn btn-primary mx-auto d-block" name="btnAdminDodaj">
                        <i class="fa-solid fa-plus"></i> Unos artikla
                      </button>
                    </div>

                  </form>

                  <?php if (isset($_SESSION["adminGreske"])): ?>
                    <div class="alert alert-danger mt-3">
                      <ul class="mb-0">
                        <?php foreach ($_SESSION["adminGreske"] as $greska): ?>
                          <li><?php echo $greska; ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php unset($_SESSION["adminGreske"]); ?>
                  <?php endif; ?>

                </div>
              </div>
            </div>

            <!-- DRUGA KOLONA -->
            <div class="col-lg-4">

              <div class="card shadow h-100 border-0">

                <div class="card-body">

                  <h4 class="text-center mb-4">Stanje artikala</h4>

                  <div class="table-responsive">

                    <table class="table table-striped table-hover text-center align-middle">

                      <thead class="table-dark">
                        <tr>
                          <th>ID</th>
                          <th>Naziv</th>
                          <th>Tip</th>
                          <th>Količina</th>
                          <th>Cena</th>
                        </tr>
                      </thead>

                      <tbody>

                        <?php
                        $upit = "SELECT * FROM artikli";
                        $rez = mysqli_query($dbc, $upit);

                        if (mysqli_num_rows($rez) > 0) {
                          while ($red = mysqli_fetch_assoc($rez)) {
                        ?>

                            <tr>
                              <td><?php echo $red["idArtikla"]; ?></td>
                              <td><?php echo $red["nazivArtikla"]; ?></td>
                              <td><?php echo $red["tipArtikla"]; ?></td>
                              <td><?php echo $red["kolicinaArtikla"]; ?></td>
                              <td><b><?php echo $red["cenaArtikla"]; ?></b></td>
                            </tr>

                          <?php }
                        } else {
                          ?>

                          <tr>
                            <td colspan="5" class="text-center text-muted">
                              <i class="fa-solid fa-box-open"></i> Nema artikala u bazi
                            </td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>

            <!-- TREĆA KOLONA -->
            <div class="col-lg-4">

              <div class="card shadow h-100 border-0">

                <div class="card-body">

                  <h4 class="text-center mb-4">Izmena artikla</h4>

                  <form action="izmeniArtikal.php" method="POST" class="needs-validation">

                    <div class="mb-3">
                      <label class="form-label">Izaberite idProizvoda</label>
                      <select name="idProizvodaIzmena" class="form-select custom-select mb-3" required>

                        <option selected disabled>Izaberite idProizvoda, proizvod, za izmenu</option>

                        <?php
                        $upit = "SELECT idArtikla 
         FROM artikli";
                        $rez = mysqli_query($dbc, $upit);
                        while ($red = mysqli_fetch_assoc($rez)):
                        ?>

                          <option <?php echo "value='$red[idArtikla]'"; ?>>
                            <?php echo $red["idArtikla"]; ?>
                          </option>

                        <?php endwhile; ?>

                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Količina proizvoda</label>
                      <input name="kolicinaProizvodaIzmena" type="number" class="form-control" placeholder="Unesite količinu proizvoda...">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Cena proizvoda</label>
                      <input name="cenaProizvodaIzmena" type="number" class="form-control" placeholder="Unesite cenu proizvoda...">
                    </div>

                    <div class="d-grid">
                      <button class="btn btn-success mx-auto d-block" name="btnAdminIzmeni">
                        <i class="fa-solid fa-pen"></i> Izvrši izmenu
                      </button>
                    </div>

                  </form>

                  <?php if (isset($_SESSION["adminGreskeIzmena"])): ?>
                    <div class="alert alert-danger mt-3">
                      <ul class="mb-0">
                        <?php foreach ($_SESSION["adminGreskeIzmena"] as $greska): ?>
                          <li><?php echo $greska; ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php unset($_SESSION["adminGreskeIzmena"]); ?>
                  <?php endif; ?>

                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="row my-4">

          <!-- TABELA -->
          <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
              <div class="card-body">

                <h5 class="text-center mb-4">Statistika pristupa sistemu</h5>

                <div class="table-responsive">
                  <table class="table table-bordered table-hover text-center align-middle">

                    <thead class="table-dark">
                      <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Tip</th>
                        <th>Broj pristupa</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      $upit = "SELECT * 
         FROM korisnici 
         ORDER BY brojPristupa DESC";

                      $rez = mysqli_query($dbc, $upit);

                      while ($red = mysqli_fetch_assoc($rez)):
                      ?>

                        <tr>
                          <td><?php echo $red["idKorisnika"]; ?></td>
                          <td><?php echo $red["ime"]; ?></td>
                          <td><?php echo $red["prezime"]; ?></td>
                          <td><?php echo $red["tipKorisnika"]; ?></td>
                          <td><b><?php echo $red["brojPristupa"]; ?></b></td>
                        </tr>

                      <?php endwhile; ?>

                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>


          <!-- OPŠTA STATISTIKA -->
          <div class="col-12">

            <div class="card shadow-sm border-0">
              <div class="card-body">

                <h5 class="text-center mb-4">Opšta statistika</h5>

                <ul class="list-group list-group-flush">

                  <li class="list-group-item">
                    <?php
                    $upit = "SELECT COUNT(*) as korisnici 
FROM korisnici 
WHERE tipKorisnika='Korisnik'";

                    $rez = mysqli_query($dbc, $upit);
                    $red = mysqli_fetch_assoc($rez);

                    echo "Broj korisnika: <b>" . $red["korisnici"] . "</b>";
                    ?>
                  </li>

                  <li class="list-group-item">
                    <?php
                    $upit = "SELECT COUNT(*) as admini 
FROM korisnici 
WHERE tipKorisnika='Administrator'";

                    $rez = mysqli_query($dbc, $upit);
                    $red = mysqli_fetch_assoc($rez);

                    echo "Broj administratora: <b>" . $red["admini"] . "</b>";
                    ?>
                  </li>

                  <li class="list-group-item">
                    <?php
                    $upit = "SELECT idKorisnika, ime, prezime, tipKorisnika 
FROM korisnici
ORDER BY brojPristupa DESC
LIMIT 1";

                    $rez = mysqli_query($dbc, $upit);
                    $red = mysqli_fetch_assoc($rez);

                    echo "Najaktivniji korisnik: <b>{" . $red["idKorisnika"] . "} " . $red["ime"] . " " . $red["prezime"] . " (" . $red["tipKorisnika"] . ")" . "</b>";
                    ?>
                  </li>

                </ul>

              </div>
            </div>

          </div>

        </div>
      </div> <!--odavde krece-->
    </div>
  </div>
  <!--SADRZAJ STRANICE-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulogujte se</title>
    <link rel="stylesheet" href="stil.css">
    <link rel="icon" type="image/png" href="slike/Logo_ZOMI.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
<body> 
    <?php if(isset($_SESSION["registracijaUspesno"])): ?>

<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Obaveštenje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body">
        <?php 
            echo $_SESSION["registracijaUspesno"]; 
            echo "Molimo Vas da se ulogujete";
            unset($_SESSION["registracijaUspesno"]);
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
<!--NAVGIJACIJA-->
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0 border-bottom border-danger-subtle border-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img id="imgNavBrand" src="slike/Logo_ZOMI.jpeg" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Početna stranica</a>
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
    <li class="nav-item">
        <a class="nav-link active" href="login.php">
            <i class="fa-regular fa-user"></i> Prijava
        </a>
    </li>
</ul>
    </div>
  </div>
</nav>
<!--NAVGIJACIJA-->
<div class="container-fluid pb-2">
 <div class="row justify-content-center py-2">
   <div class="col-md-4">
       <h1 class="display-1 text-center">Ulogujte se</h1>
       <form id="loginForma" class="row g-3 needs-validation" novalidate>
          <div class="row"> <!--LOGOVANJE-->
              <label for="validationCustom01" class="form-label">Email adresa</label>
              <input name="mailLogin" id="validationCustom01" type="email" class="form-control" placeholder="Unesite email adresu..." required>
              <div class="valid-feedback">
                  Looks good!
              </div>
          </div>
          <div class="row">
              <label for="validationCustom02" class="form-label">Lozinka</label>
              <input name="lozinkaLogin" id="validationCustom02" type="password" class="form-control" placeholder="Unesite lozinku..." required>
              <div class="valid-feedback">
              Looks good!
              </div>
          </div>             
          <div class="row">
              <button class="btn btn-primary" type="submit" name="btnLogin">Submit form</button>
          </div>
          <div id="loginGreskeAjax" class="alert alert-danger mt-3 d-none"></div>
        </form>
        <?php if(isset($_SESSION["loginGreske"])): ?>
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            <?php foreach($_SESSION["loginGreske"] as $greska): ?>
                <li><?php echo $greska; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION["loginGreske"]); ?>
<?php endif; ?>

    </div>
  </div>
  <div class="row justify-content-center py-2">
    <div class="col-md-4">
      <h1 class="display-1 text-center">Registrujte se</h1>
      <form action="validacijaLogin.php" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
      <div class="row">
        <label for="validationCustom01" class="form-label">Ime</label>
        <input name="registracijaIme" type="text" class="form-control" id="validationCustom01" placeholder="Unesite ime..." required>
        <div class="valid-feedback">
            Looks good!
        </div>
      </div>
      <div class="row">
        <label for="validationCustom02" class="form-label">Prezime</label>
        <input name="registracijaPrezime" type="text" class="form-control" id="validationCustom02" placeholder="Unesite prezime..." required>
        <div class="valid-feedback">
        Looks good!
        </div>
      </div>
      <div class="row">
          <label for="validationCustomUsername" class="form-label">Email adresa</label>
          <input name="registracijaMail" type="email" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" placeholder="Unesite email adresu..." required>
          <div class="invalid-feedback">
              Please choose a username.
          </div>
      </div>
      <div class="row">
          <label for="validationCustom03" class="form-label">Lozinka</label>
          <input name="registracijaLozinka" type="password" class="form-control" id="validationCustom03" placeholder="Unesite lozinku..." required>
          <div class="invalid-feedback">
          Please provide a valid city.
          </div>
      </div>
      <div class="row">
          <label for="validationCustom09" class="form-label">Potvrdite lozinku</label>
          <input name="registracijaLozinka1" type="password" class="form-control" id="validationCustom09" placeholder="Ponovo unesite lozinku..." required>
          <div class="invalid-feedback">
          Please provide a valid city.
      </div>
      </div>
      <div class="row">
          <label for="validationCustom04" class="form-label">Broj telefona</label>
          <input name="registracijaTelefon" type="text" class="form-control" id="validationCustom04" placeholder="Unesite broj telefona..." required>
          <div class="invalid-feedback">
            Please select a valid state.
          </div>
      </div>
      <div class="row">
          <label for="validationCustom05" class="form-label">Adresa</label>
          <input name="registracijaAdresa" type="text" class="form-control" id="validationCustom05" placeholder="Unesite punu adresu i broj..." required>
          <div class="invalid-feedback">
            Please select a valid state.
          </div>
      </div>
      <div class="row">
          <label for="validationCustom010" class="form-label">Priložite vašu fotografiju...</label>
          <input name="registracijaDatoteka" type="file" class="form-control" id="validationCustom010" required>
          <div class="invalid-feedback">
            Please select a valid state.
          </div>
      </div>
      <div class="row">
          <div class="form-check">
          <input name="registracijaUslovi" class="form-check-input" type="checkbox" id="invalidCheck" required>
          <label class="form-check-label">
              Prihvatam i pročitao/la sam <a class="link-secondary  link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="zomiUslovi.pdf" target="_blank"><i>uslove korišćenja</i></a>
          </label>
          <div class="invalid-feedback">
              You must agree before submitting.
          </div>
          </div>
      </div>
      <div class="row">
          <button name="btnRegistracija" class="btn btn-primary" type="submit">Submit form</button>
      </div>
      </form>
      <?php if(isset($_SESSION["registracijaGreske"])): ?>
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            <?php foreach($_SESSION["registracijaGreske"] as $greska): ?>
                <li><?php echo $greska; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION["registracijaGreske"]); ?>
<?php endif; ?>
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

<script>

document.getElementById("loginForma").addEventListener("submit", function(e){

    e.preventDefault();

    let formData = new FormData(this);

    fetch("validacijaLogin.php",{
        method:"POST",
        body:formData,
        headers:{
            "Accept":"application/json"
        }
    })
    .then(res=>res.json())
    .then(data=>{

        if(data.status === "ok"){
            window.location.href = "index.php";
        }
        else{

            let div = document.getElementById("loginGreskeAjax");
            div.classList.remove("d-none");

            let html = "<ul>";

            data.greske.forEach(g=>{
                html += "<li>"+g+"</li>";
            });

            html += "</ul>";

            div.innerHTML = html;
        }

    })
    .catch(err=>{
        console.log(err);
    });

});

</script>

</body>
</html>
<?php
    session_start();
    //includes
    require_once "./hv-html-engine/hv-html-engine.php";
    require_once 'db/DB.php';
    require_once 'db/sql.php';
    require_once 'db/user.php';

    //variables
    $hv_html_engine = new HV_HTML_Engine();

    //functions calls
    checkPHPVersion();
    
    //if´s
    if (isset($notification)) {
        echo("<div style='background:orange; position:fixed; bottom:20px; left:0px; z-index:999; padding:10px;'>Info: ".$notification."</div>");
    }
    
    //functions
    function checkPHPVersion() {
        if (version_compare(phpversion(), '8.1.0', '<')) {
          echo 'PHP Version is too old. Please update to 8.1.0 or higher.';
          exit();
        }
      }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBS Projekt BahnAPI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/style.css">
  </head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white DbahnBorderBottom">
      <div class="container-fluid">
        <!-- Left side -->
          <a class="navbar-brand align-items-center" href="index.php">
            <img
              src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Deutsche_Bahn_AG-Logo.svg/1024px-Deutsche_Bahn_AG-Logo.svg.png"
              height="28"
              alt="DB Logo"
              loading="lazy"
            />
          <!-- /Left side -->
          <!-- middle -->
          <span class="navbar-text h5 align-items-center">
            API-Projekt
          </span>
          <!-- /middle -->
          <!-- Right elements -->
          <div class="d-flex align-items-center">
            <?php
              if (isset($_SESSION['userName'])) {
                echo("<p class='h3'>Hallo ".$_SESSION['userName']."</p>");
                echo("<a class='btn btn-outline-dark ml-4 text-white DbahnBackground' href='db/logout.php'>Logout</a>");
              } 
              else {
                echo("<a type='button' class='btn btn-outline-dark mr-5' data-toggle='modal' data-target='#loginModal'>Login</a>");
                echo("<a type='button' class='btn btn-outline-dark mr-3 text-white DbahnBackground' data-toggle='modal' data-target='#registrierenModal'>Registrieren</a>");
              }
            ?>
          </div>
          <!-- /Right elements -->
      </div>
    </nav>
    <!-- /Navbar -->
    <!-- Content -->
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <h1>Main Content</h1>
            </div>
        </div>
    </div>
    <!-- /Content -->
    <!-- footer -->
    <div class="row fixed-bottom DbahnBackground">
      <hr>
      <div class="col-md-4 col-sm-4 col-xs-4 d-flex align-items-center justify-content-center mt-2">
        <p class="text-white">© 2023 - BBS PHP Projekt Bahn-API</p>
      </div>
      <div class="col-md-8 col-sm-8 col-xs-8 d-flex align-items-center justify-content-center mt-2">
        <p class="text-white">Kai, Dennis und Robert</p>
      </div>
    </div>
    <!-- /footer -->
    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Login</h5>
              <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
          </div>
          <form action="index.php" method="post">
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-4 d-flex justify-content-center align-items-center">Benutzer Name:</div>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                  <input type="text" class="form-control mt-2 w-75" id="userName" name="userName" placeholder="User Name">
                </div>
                <div class="col-sm-4 d-flex justify-content-center align-items-center">Passwort:</div>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                  <input class="form-control mt-2 w-75" type="password" name="password" id="password" placeholder="Passwort">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-outline-dark text-white DbahnBackground" name="btnLogin" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /Modal Login -->
    <!-- Modal Registrieren -->
    <div class="modal fade" id="registrierenModal" tabindex="-1" role="dialog" aria-labelledby="registrierenModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Registrieren</h5>
              <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
          </div>
          <form action="index.php" method="post">
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-4 d-flex justify-content-center align-items-center">Benutzer Name:</div>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                  <input type="text" class="form-control mt-2 w-75" id="userName" name="userName" placeholder="User Name">
                </div>
                <div class="col-sm-4 d-flex justify-content-center align-items-center">Passwort:</div>
                <div class="col-sm-8 d-flex justify-content-center align-items-center">
                  <input class="form-control mt-2 w-75" type="password" name="password" id="password" placeholder="Passwort">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-outline-dark text-white DbahnBackground" name="btnCreateUser" value="Registrieren">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /Modal Registrieren -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
<?php
// Engine Wiki
//
// create a new HV_HTML_Engine
// $hv_html_engine = new HV_HTML_Engine();
//
// create a new table
// $hv_html_engine->getTable($array2D, $class, $id, $style, $orderBy, $orderDirection, $thClass, $tdClass);
//
// create a new a
// $hv_html_engine->getA($text, $class, $id, $style, $href);
//
// create a new p
// $hv_html_engine->getP($text, $class, $id, $style);
//
// create a new button
// $hv_html_engine->getButton($text, $class, $id, $style);
//
// create a new img
// $hv_html_engine->getImg($class, $id, $style, $src);
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Register / Login Wiki
//
// Register form:
// <form action="index.php" method="post">
//     <label for="userName">Benutzername</label>
//     <input type="text" name="userName" id="userName"><br>
//     <label for="password">Passwort</label>
//     <input type="password" name="password" id="password"><br>
//     <input type="submit" name="btnCreateUser" value="Benutzer erstellen">
//     <br>
//     <input type="submit" name="btnReset" value="DB zurücksetzen">
// </form>

// Login form:
// <form action="index.php" method="post">
//     <label for="userName">Benutzername</label>
//     <input type="text" name="userName" id="userName"><br>
//     <label for="password">Passwort</label>
//     <input type="password" name="password" id="password"><br>
//     <input type="submit" name="btnLogin" value="Einloggen">
// </form>
//
// Wenn der User eingeloggt ist, wird der Name in der Session gespeichert -> $_SESSION['userName']

// Um die Datenbank zurück zu setzten, muss einfach nur das GET Parameter "resetDB" gesetzt werden
// Beispiel: http://localhost/index.php?resetDB
// Beispiel: http://localhost:3000/index.php?resetDB <-- für mich (Kai)
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>
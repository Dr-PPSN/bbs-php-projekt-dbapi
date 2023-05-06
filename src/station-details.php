<?php
session_start();
require_once "../hv-html-engine/hv-html-engine.php";
require_once "../hv-html-engine/hv-station-details.php";
require_once "../hv-html-engine/hv-fahrplan.php";
require_once "../hv-html-engine/hv-map.php";
require_once '../db/DB.php';
require_once '../db/sql.php';
require_once '../db/user.php';
require_once '../api/api-service.php';
require_once './helper.php';
require_once '../api/helper.php';

//functions calls
if (phpVersionZuAlt()) {
  exit();
}

//if´s
if (isset($_GET['stationID'])) {
  $stationID = $_GET['stationID'];
  if (isset($_GET['datetime'])) {
    $zeit = $_GET['datetime'];
  } else {
    $zeit = null;
  }

  $details = new HV_StationsDetails($stationID, "stations-details vw-100", "", "");
  if ($details->getKeineDatenGefunden()) {
    routeZurFehlerSeite();
  }

  $stationPictureURL = bauePictureUrlZusammen(getStationPictureURL($stationID));
  $map = new HV_Map($details->getCoordinates(), "map", "map", "");
  $fahrplan = new HV_Fahrplan($details->getEvaNumber(), $zeit, "fahrplan  ", "", "");
} else {
  routeZurIndex();
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BBS Projekt BahnAPI</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/style/style.css">
  <link rel="stylesheet" href="../assets/style/stationdetails.css">
  <link rel="stylesheet" href="../assets/style/fahrplan.css">
  <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
  <style>
    .bg-station-pic {
        background: url('<?=$stationPictureURL;?>') no-repeat center center fixed;
        background-size: cover;
    }
    .ol-unselectable {
      border: 1px solid black;
    }
  </style>
  <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
</head>

<body class="bg-white">
  <?php
    if (isset($notification)) {
        echo("<div style='background:orange; bottom:20px; left:0px; z-index:999; padding:10px;'>Info: ".$notification."</div>");
      }
  ?>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white DbahnBorderBottom" id="navBar">
    <div class="container-fluid">
      <!-- Left side -->
      <a class="navbar-brand align-items-center" href="../index.php" style='display: flex'>
        <img
          src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Deutsche_Bahn_AG-Logo.svg/1024px-Deutsche_Bahn_AG-Logo.svg.png"
          height="28" alt="DB Logo" loading="lazy" />
        <!-- /Left side -->
        <!-- middle -->
        <span class="navbar-text h5 align-items-center ml-2" style='margin: auto'>
          API-Projekt
        </span>
        <!-- /middle -->
        <!-- Right elements -->
        <div class="d-flex align-items-center">
          <?php
          if (isset($_SESSION['userName'])) {
            echo ("<p class='h3' style='margin: auto'>Hallo " . $_SESSION['userName'] . "</p>");
            echo ("<a class='btn btn-outline-dark ml-4 text-white DbahnBackground' href='..db/logout.php'>Logout</a>");
          } else {
            echo ("<a type='button' class='btn btn-outline-dark mr-5' data-toggle='modal' data-target='#loginModal'>Login</a>");
            echo ("<a type='button' class='btn btn-outline-dark mr-3 text-white DbahnBackground' data-toggle='modal' data-target='#registrierenModal'>Registrieren</a>");
          }
          ?>
        </div>
        <!-- /Right elements -->
    </div>
  </nav>
  <!-- /Navbar -->


  <!-- Content -->
  <!-- station details -->
  <div class='container-fluid bg-station-pic'>
    <div class="row pt-4">
      <div class="col-12 d-flex justify-content-center">
        <br>
      </div>
    </div>
    <div class="row pt-4">
      <div class="col-md-2 col-sm-0 px-0 pt-5 mt-5 d-flex align-self-end"></div>
      <div class="col-md-8 col-sm-12 pt-3 DbahnBorder kastenBG">
        <form action="suche.php" method="GET">
          <h1 class="my-4 DbahnText" id="an1">Bahnhof-Suche</h1>
          <input type="text" placeholder="Bahnhof" name="searchStation" id="station" class="form-control mb-4">
          <input type="submit" value="Suchen" class="form-control btn btn-outline-dark text-white DbahnBackground mb-4">
        </form>
        <hr>
        <div class="row mb-3">
          <h1 class='col-8 pl-4'><?=$details->getStationName();?></h1>
          <div class='col-4' style='display: flex'>
            <form action="" method="GET" style='margin: auto'>
              <button class="favourite-icon form-control btn btn-outline-dark text-white DbahnBackground mb-4">
                <div class="favourite-icon">&#9829;</div>
              </button>
            </form>
          </div>
        </div>


        <div class="row mb-5">
          <div class="col-md-9 col-sm-8 pl-4 d-flex justify-content-center">
            <div class="w-100">

              <?=$map->getMap();?>

              <div class="mt-4 mb-4">
                <?=$fahrplan->getFahrplanHeader();?>
              </div>

              <div class="row" style='justify-content: center;'>
                <div class="col-10 row fahrplan-navigation" style='justify-content: center;'>
                  <div class="col-3 d-flex">
                    <form>
                      <input type="hidden" name="stationID" value="<?=$stationID; ?>">
                      <input type="hidden" name="datetime" value="1 stunde später">
                      <input class="form-control btn btn-outline-dark text-white DbahnBackground" type="submit" value="1 Stunde früher">
                    </form>
                  </div>
                  <div class="col-6">
                    <form class="row" style='justify-content: center;'>
                      <input type="hidden" name="stationID" value="<?=$stationID; ?>">
                      <input class="col-5 form-control" type="datetime-local" name="datetime" id="datetime">
                      <input class="col-5 ml-3 form-control btn btn-outline-dark text-white DbahnBackground" type="submit" value="Suchen">
                    </form>
                  </div>
                  <div class="col-3">
                    <div class="d-flex fahrplan-navigation-later">
                      <form style="margin-right: 0px; margin-left: auto;">
                        <input type="hidden" name="stationID" value="<?=$stationID; ?>">
                        <input type="hidden" name="datetime" value="1 stunde später">
                        <input class="form-control btn btn-outline-dark text-white DbahnBackground" type="submit" value="1 Stunde später">
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?=$fahrplan->getFahrplan();?>
            </div>
          </div>
          <div class="col-md-3 col-sm-4 d-flex justify-content-center">
            <?=$details->getDetails();?>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-md-12 col-sm-12 pl-5 pr-5">
            TODO: Input für andere Zeiten
          </div>
        </div> -->
      </div>
      <div class="col-md-2 col-sm-0 px-0 py-5 my-5 d-flex align-self-end"></div>
    </div>
  </div>
  <!-- /station details -->

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
        <form action="../index.php" method="post">
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-sm-4 d-flex justify-content-center align-items-center">Benutzer Name:</div>
              <div class="col-sm-8 d-flex justify-content-center align-items-center">
                <input type="text" class="form-control mt-2 w-75" id="userName" name="userName" placeholder="User Name">
              </div>
              <div class="col-sm-4 d-flex justify-content-center align-items-center">Passwort:</div>
              <div class="col-sm-8 d-flex justify-content-center align-items-center">
                <input class="form-control mt-2 w-75" type="password" name="password" id="password"
                  placeholder="Passwort">
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
  <div class="modal fade" id="registrierenModal" tabindex="-1" role="dialog" aria-labelledby="registrierenModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Registrieren</h5>
          <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
        </div>
        <form action="../index.php" method="post">
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-sm-4 d-flex justify-content-center align-items-center">Benutzer Name:</div>
              <div class="col-sm-8 d-flex justify-content-center align-items-center">
                <input type="text" class="form-control mt-2 w-75" id="userName" name="userName" placeholder="User Name">
              </div>
              <div class="col-sm-4 d-flex justify-content-center align-items-center">Passwort:</div>
              <div class="col-sm-8 d-flex justify-content-center align-items-center">
                <input class="form-control mt-2 w-75" type="password" name="password" id="password"
                  placeholder="Passwort">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-outline-dark text-white DbahnBackground" name="btnCreateUser"
              value="Registrieren">
        </form>
      </div>
    </div>
  </div>
  </div>
  <!-- /Modal Registrieren -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>
</body>

</html>
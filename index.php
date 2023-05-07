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
      echo("<div id='' style='background:orange; bottom:20px; left:0px; z-index:999; padding:10px;'>Info: ".$notification."</div>");
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
    <link rel="stylesheet" href="assets/style/favoritenOverlay.css">
  </head>
<body class="bg-white">
    <video id="background-video" class="inline-media hero-intro-video-video parallax" width="100%" height="100%" aria-hidden="true" preload="none" data-load-timeout="3000" muted="" playsinline="" autoplay="" loop="" src="https://hevor.de/vid/db2.mp4"></video>
    <!-- Sidebar -->
    
    <!-- /Sidebar -->
    <!-- Dark Overlay element -->
    <div class="overlay"></div>
    <!-- /Dark Overlay element -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white DbahnBorderBottom" id="navBar">
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
    <div class="container-fluid position-relative DbahnBackground" id="container_p_1">
      <div class="row p-2 ">
        <div class="col-12 d-flex align-items-center justify-content-center">
          <h1 class="text-white" id="ueberschrift2">Willkommen bei der Deutschen-Bahn</h1>
        </div>
      </div>
    </div>
    <!-- Bahnhof suche -->
    <div class="container-fluid py-5 my-5">
        <div class="row pt-5">
          <div class="col-12 d-flex justify-content-center">
            <br>
          </div>
        </div>
        <div class="row py-5 my-5">
          <div class="col-md-3 col-sm-0 px-0 pt-5 mt-5 d-flex align-self-end"></div>
          <div class="col-md-6 col-sm-12 d-flex justify-content-center DbahnBorder kastenBG">
            <form action="./src/suche.php" method="GET">
              <h1 class="my-4 DbahnText" id="an1">Bahnhof-Suche</h1>
              <input type="text" placeholder="Bahnhof" name="searchStation" id="station" class="form-control mb-4">
              <input type="submit" value="Suchen" class="form-control btn btn-outline-dark text-white DbahnBackground mb-4">
            </form>
          </div>
          <div class="col-md-3 col-sm-0 px-0 py-5 my-5 d-flex align-self-end"></div>
        </div>
    </div>
    <!-- /Bahnhof suche -->
    <!-- carousel -->
    <div class="container-fluid position-relative DbahnBackground" id="container_p_1">
      <div class="row pt-4 ">
        <div class="col-12 align-items-center justify-content-center">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-4 mr-3">
                                <a href="https://www.bahn.de/angebot/sparpreis-flexpreis/super-sparpreis-young" class="sld-tsr__image-link" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung">
                                    <figure class="">
                                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/640x320/dam/jcr:c78c6a43-bc75-4cbe-b2d5-51ef4b62fe6e/17a_Freestyle_Alleinreisende_01-0056_om.jpg" class="js-sld__img sld-tsr__image" alt="Fotoshooting Fernverkehr 2022">
                                    </figure>
                                </a>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 mr-4 pr-4">
                                <div class="">
                                    <div class="">
                                        <h3 class="h3 text-white">Super Sparpreis Young</h3>
                                        <div><p class="text-white">Günstig <strong>ab 12,90 Euro</strong> innerhalb Deutschlands reisen - für alle unter 27.</p>
                                        </div>
                                        <a href="https://www.bahn.de/angebot/sparpreis-flexpreis/super-sparpreis-young" class="stretched-link" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung"></a>
                                    </div>
                                    <div class="">
                                        <a class="btn text-white" href="https://www.bahn.de/angebot/sparpreis-flexpreis/super-sparpreis-young" aria-hidden="true" tabindex="-1" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung">> Zum Super Sparpreis Young
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-4 mr-3">
                            <a class="" href="https://www.bahn.de/angebot/zusatzticket/gepaeck" data-track="" data-trackingcode="teaserSliderBigImage_1-2_link_Gepaeckservice">
                                <figure class="">
                                    <img src="https://assets.static-bahn.de/.imaging/focalpoint/640x320/dam/jcr:b63a1796-6ffb-434a-88f9-7439442ed578/AdobeStock_204334511%20s.jpg" class="js-sld__img sld-tsr__image" alt="">
                                </figure>
                            </a>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 mr-4 pr-4">
                                <div class="">
                                    <div class="">
                                        <h3 class="h3 text-white">Schicken Sie Ihre Koffer vor</h3>
                                        <div><p class="text-white">Entspannt anreisen: Lassen Sie Ihren Koffer bequem zuhause abholen. Oder geben Sie ihn im Hermes PaketShop ab und sparen Sie dabei.</p>
                                        </div>
                                        <a href="https://www.bahn.de/angebot/zusatzticket/gepaeck" class="stretched-link" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung"></a>
                                    </div>
                                    <div class="">
                                        <a class="btn text-white" href="https://www.bahn.de/angebot/zusatzticket/gepaeck" aria-hidden="true" tabindex="-1" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung">> Gepäckservice buchbar ab 14,90 Euro
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-4 mr-3">
                                <a class="" href="https://www.bahn.de/service/individuelle-reise/kinder/ausflugsziele" data-track="" data-trackingcode="teaserSliderBigImage_1-3_link_InspoReisenKind">
                                    <figure class="">
                                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/640x320/dam/jcr:703dbf36-fc41-461e-8845-16e9d07503e4/40_Mutter_und_Vater_Familie_2_und_Kind_12_Schulkind_6_8J_4erSitz_00343_om.jpg" class="js-sld__img sld-tsr__image" alt="Fotoshooting Fernverkehr 2022">
                                    </figure>
                                </a>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 mr-4 pr-4">
                                <div class="">
                                    <div class="">
                                        <h3 class="h3 text-white">Reisen mit Kind</h3>
                                        <div><p class="text-white">Entdecken Sie <strong>die&nbsp;schönsten Ausflugsziele</strong>&nbsp;für kleine und große Bahnfahrer.&nbsp;</p>
                                        </div>
                                        <a href="https://www.bahn.de/service/individuelle-reise/kinder/ausflugsziele" class="stretched-link" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung"></a>
                                    </div>
                                    <div class="">
                                        <a class="btn text-white" href="https://www.bahn.de/service/individuelle-reise/kinder/ausflugsziele" aria-hidden="true" tabindex="-1" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung">> Ausflugsziele anzeigen
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-4 mr-3">
                                <a class="" href="https://www.bahn.de/bahnbusiness/geschaeftsreisen/services" data-track="" data-trackingcode="teaserSliderBigImage_1-4_link_GeschaeftsreisenBahn">
                                    <figure class="">
                                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/640x320/dam/jcr:83782d19-8fda-46d7-bf82-d1c355e062f5/Geschaaeftsreisende_1280x440.jpg" class="js-sld__img sld-tsr__image" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 mr-4 pr-4">
                                <div class="">
                                    <div class="">
                                        <h3 class="h3 text-white">Geschäftsreisen: Besser mit der Bahn</h3>
                                        <div><p class="text-white">Reisen Sie mit den <strong>Angeboten von bahn.business </strong>produktiv, klimafreundlich und flexibel.</p>
                                        </div>
                                        <a href="https://www.bahn.de/bahnbusiness/geschaeftsreisen/services" class="stretched-link" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung"></a>
                                    </div>
                                    <div class="">
                                        <a class="btn text-white" href="https://www.bahn.de/bahnbusiness/geschaeftsreisen/services" aria-hidden="true" tabindex="-1" data-track="external" data-trackingcode="teaserSliderBigImage_1-1_button_SuperSparpreisYoung">> Weitere Infos
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
      </div>
    </div>
    <!-- /carousel -->
    <!-- Teaser-Block -->
    <div class="container-fluid py-5 position-relative bg-ice1">
        <div class="row">
          <div class="col-md-2 col-sm-0 px-0 pt-5 mt-5 d-flex align-self-end"></div>
          <div class="col-md-8 col-sm-12 DbahnBorder kastenBG">
            <div class="row">
                <div class="col-4 border-right-dotted">
                    <figure>
                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/560x280/dam/jcr:a882bab7-7798-4d6c-88ae-603ceb40652c/BahnCard_4z2_V02.svg" class="image content-teaser__image" alt="">
                    </figure>
                    <h3>BahnCard</h3>
                    <div><p>Profitieren Sie von&nbsp;<strong>25 Prozent&nbsp;</strong>oder bis zu&nbsp;<strong>50 Prozent Rabatt</strong>.</p></div>
                </div>
                <div class="col-4 border-right-dotted">
                    <figure>
                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/560x280/dam/jcr:fcad2af7-a007-4376-b23f-07c39d9bd105/bahnbonus_grau_NoBG.svg" class="image content-teaser__image" alt="">
                    </figure>
                    <h3>BahnBonus</h3>
                    <div><p>Jetzt anmelden, um BahnBonus Punkte mit Ihrer BahnCard oder mit der kostenlosen BahnBonus Card zu sammeln.</p></div>
                </div>
                <div class="col-4">
                    <figure>
                        <img src="https://assets.static-bahn.de/.imaging/focalpoint/560x280/dam/jcr:012c63a6-968c-4ee5-afac-cba4b8217f69/227147-304523_Piktogramm_urlaub_staedtereisen_NoBG.svg" class="image content-teaser__image" alt="">
                    </figure>
                    <h3>Urlaub und Städtereisen</h3>
                    <div><p>Städtereisen mit Bahn und Hotel: Profitieren Sie von unseren günstigen Kombi-Paketen.</p></div>  
                </div>
            </div><br>
            <div class="row pb-3">
                <div class="col-4">
                        <center>
                            <a href="https://www.bahn.de/angebot/bahncard" class="btn btn-outline-dark text-white DbahnBackground" data-track="" data-trackingcode="teaserBlock_3-1_link_BahnCard">Alle BahnCards in der Übersicht</a>
                        </center>
                    
                </div>
                <div class="col-4">
                        <center>
                            <a href="https://www.bahn.de/service/bahnbonus" class="btn btn-outline-dark text-white DbahnBackground" data-track="" data-trackingcode="teaserBlock_3-2_link_BahnBonus">Zu BahnBonus</a>
                        </center>
                    
                </div>
                <div class="col-4">
                        <center>
                            <a href="https://www.bahn.de/angebot/urlaub" class="btn btn-outline-dark text-white DbahnBackground" data-track="" data-trackingcode="teaserBlock_3-3_link_UrlaubStaedtereisen">Zu den Angeboten</a>
                        </center>
                    
                </div>
            </div>
          </div>
        </div>
    <!-- /Teaser-Block -->
    <!-- Content -->
    <div class="container-fluid position-relative mt-5">
      <div class="row">
        <div class="col-1"></div>
        <div class="col-10 align-items-center justify-content-center DbahnBackground" id="aboutDB">
            <h1 class="text-center text-white">Die Deutsche Bahn</h1>
            <p class="text-center text-white">Die Deutsche Bahn AG (kurz DB AG, DB oder DBAG) ist ein deutsches Verkehrsunternehmen mit Sitz in Berlin. Es entstand 1994 aus der Fusion der Deutschen Bundesbahn und der Deutschen Reichsbahn und umfasst heute als Eisenbahnverkehrsunternehmen neben dem Eisenbahninfrastrukturunternehmen DB Netz AG und dem Personenverkehrsunternehmen DB Fernverkehr AG auch zahlreiche weitere Tochterunternehmen. Die Deutsche Bahn ist das größte Eisenbahnverkehrsunternehmen in Deutschland und das zweitgrößte weltweit. Sie ist eine Aktiengesellschaft und seit 1999 mehrheitlich im Besitz des Bundes. Die DB AG ist Mitglied im Tarifverband der Bundeseigenen und Nichtbundeseigenen Eisenbahnen in Deutschland (TBNE).</p><br>
        </div>
        <div class="col-1"></div>
      </div>
    </div>
    <!-- /Content -->
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="assets/script/script.js"></script>
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
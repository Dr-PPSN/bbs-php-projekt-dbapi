<?php
    include "./hv-html-engine/hv-html-engine.php";
    $example = array(
        array("Name" => "John", "Age" => 25
        ),
        array("Name" => "Mary", "Age" => 30
        ),
        array("Name" => "Peter", "Age" => 35
        ));
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBS Projekt BahnAPI</title>
</head>
<body>
    <?php
        echo "Hallo Welt<br>";
        $hv_html_engine = new HV_HTML_Engine();
        echo $hv_html_engine->getA("Test", false, "", "", "https://www.google.de");
        echo "<br><br><br>";
        echo $hv_html_engine->getTable($example, "", "", "", "", "");
    ?>
</body>
</html>
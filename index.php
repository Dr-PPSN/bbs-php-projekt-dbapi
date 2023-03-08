<?php
    include "./hv-html-engine/hv-html-engine.php";
    $hv_html_engine = new HV_HTML_Engine();

    $array2D = [  ['id' => 1, 'name' => 'Alice', 'age' => 25],
    ['id' => 2, 'name' => 'Bob', 'age' => 30],
    ['id' => 3, 'name' => 'Charlie', 'age' => 20],
  ];
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
        // echo $hv_html_engine->getTable($array2D, "myClass", "myID", "", "1", "DESC", "thClass", "tdClass");
        // echo "<br><br>";
        echo $hv_html_engine->getTable($array2D, "tableClass", "tableID", "", "age", "ASC", "THCLASS", "TDCLASS");
        echo "<br><br><br><br>";
        
    ?>
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
?>
<?php
    include "./hv-html-engine/hv-html-engine.php";
    $hv_html_engine = new HV_HTML_Engine();

    $array2D = array(
        array("ID", "Name", "Alter"),
        array("1", "Hans", "20"),
        array("2", "Peter", "30"),
        array("3", "Klaus", "40"),
        array("4", "Kai", "50"),
        array("5", "Max", "60"),
    );
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
        echo $hv_html_engine->getTable($array2D, "", "", "", "", "", "", "");
        echo "<br><br><br><br>";
        echo createTable($array2D, "myClass", "myID", "", "1", "DESC");

        function createTable($array2D, $class, $id, $style, $orderBy, $orderDirection) {
            // Prüfen, ob das übergebene Array ein 2D-Array ist
            if (!is_array($array2D) || empty($array2D) || !is_array($array2D[0])) {
                return;
            }

            // Erstelle die Tabellenüberschrift
            $keys = array_keys($array2D[0]);
            $tableHead = '<thead><tr>';
            foreach ($keys as $key) {
                $tableHead .= '<th>' . $array2D[0][$key] . '</th>';
            }
            $tableHead .= '</tr></thead>';

            // Entferne die erste Zeile des 2D-Arrays
            array_shift($array2D);

            // Wenn $orderBy und $orderDirection angegeben wurden, sortiere das Array
            if ($orderBy && in_array($orderDirection, ['ASC', 'DESC'])) {
                $sortedArray = array();
                foreach ($array2D as $key => $row) {
                    $sortedArray[$key] = $row[$orderBy];
                }
                array_multisort($sortedArray, $orderDirection == 'ASC' ? SORT_ASC : SORT_DESC, $array2D);
            }

            // Erstelle die Tabellenzeilen
            $tableBody = '<tbody>';
            foreach ($array2D as $row) {
                $tableBody .= '<tr>';
                foreach ($row as $value) {
                    $tableBody .= '<td>' . $value . '</td>';
                }
                $tableBody .= '</tr>';
            }
            $tableBody .= '</tbody>';

            // Erstelle die Tabelle
            $table = '<table';
            if ($class) {
                $table .= ' class="' . $class . '"';
            }
            if ($id) {
                $table .= ' id="' . $id . '"';
            }
            if ($style) {
                $table .= ' style="' . $style . '"';
            }
            $table .= '>' . $tableHead . $tableBody . '</table>';

            return $table;
        }

        
        
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
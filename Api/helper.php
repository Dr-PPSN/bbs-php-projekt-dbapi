<?php

function printPretty($array) {
  $json = json_encode($array, JSON_PRETTY_PRINT);
  echo "<pre>";
  highlight_string("<?php\n\$json = " . var_export($json, true) . ";\n>");
  echo "</pre>";
}

?>
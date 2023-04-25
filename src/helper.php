<?php

function phpVersionZuAlt(): bool
{
  if (version_compare(phpversion(), '8.1.0', '<')) {
    echo 'PHP Version is too old. Please update to 8.1.0 or higher.';
    return true;
  } else {
    return false;
  }
}

function routeZurIndex() {
  header('Location: ../index.php');
  exit();
}

?>
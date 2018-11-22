<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("MedicamentBrowseViewModel");
?>

<html>
  <head>
  </head>
  <body>
    Medicament browser
  </body>
</html>

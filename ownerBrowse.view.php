<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("OwnerBrowseViewModel");
?>

<html>
  <head>
  </head>
  <body>
    Owner browser
  </body>
</html>

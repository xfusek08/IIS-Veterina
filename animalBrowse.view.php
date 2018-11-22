<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimaBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimaBrowseViewModel");
?>

<html>
  <head>
  </head>
  <body>
    Animal browser
  </body>
</html>

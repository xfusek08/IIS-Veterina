<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("EmployeeBrowseViewModel");
?>

<html>
  <head>
  </head>
  <body>
    Employee browser
  </body>
</html>

<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("EmployeeBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
  </head>
  <body>
    <?php include 'menu.php';?>
    Employee browser
  </body>
</html>

<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
?>

<html>
  <head>
  </head>
  <body>
    <?php include 'menu.view.php';?>
    Animal Detail
  </body>
</html>

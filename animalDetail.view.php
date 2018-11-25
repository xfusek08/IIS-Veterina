<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
  </head>
  <body>
    <?php include 'menu.php';?>
    Animal Detail
  </body>
</html>

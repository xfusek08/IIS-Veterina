<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OptionDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("OptionDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
  </head>
  <body>
  <?php include 'menu.php';?>
    <div class="content">
    </div>
  </body>
</html>
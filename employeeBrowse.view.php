<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("EmployeeBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <h1>Employee browser</h1>
      <form action="" method="get">
        <input type="text" value="" placeHolder="Vyhledat..." name="search">
        <input type="submit" name="searchButton" class="searchButton">
      </form>
    </div>
  </body>
</html>

<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("MedicamentBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
  </head>
  <body>
  <?php include 'menu.php';?>
    <h1>Seznam léků</h1>
    <input type="text" placeholder="Vyhledat..." name="">
    <table>
      <thead>
        <th>Název</th>
        <th>Typ</th>
        <th>Cena</th>
        <th>Výrobce</th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </body>
</html>

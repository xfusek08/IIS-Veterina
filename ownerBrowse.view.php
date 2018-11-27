<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("OwnerBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
  </head>
  <body>
    <?php include 'menu.php';?>
    <h1>Seznam majitelů</h1>
    <input type="text" placeholder="Vyhledat..." name="">
    <table>
      <thead>
        <th>Jméno</th>
        <th>Adresa</th>
        <th>Telefon</th>
        <th>Pohlaví</th>
      </thead>
      <tbody>
      <tr><th class="table_add table_select" colspan="4">Přidat zvíře</th></tr>
      </tbody>
    </table>
  </body>
</html>

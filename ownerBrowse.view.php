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
    <form action="" method="get">
      <input type="text" value="" placeHolder="Vyhledat..." name="search">
      <input type="submit" name="searchButton" class="searchButton">
    </form>
    <table>
      <thead>
        <th>Jméno</th>
        <th>Příjmení</th>
        <th>Adresa</th>
        <th>Telefon</th>
        <th>Pohlaví</th>
        <th>Stav</th>
      </thead>
      <tbody>
      <?php while(($actEnt = $actVM->Owner->getNext()) != null) { ?>
        <tr class="table_select" onclick="changePage(<?= $actEnt->getColumnStringValue('own_pk') ?>, 'ownerDetail.view.php')">
          <td><?= $actEnt->getColumnStringValue('own_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('own_surname') ?></td>
          <td><?= $actEnt->getColumnStringValue('own_address') ?></td>
          <td><?= $actEnt->getColumnStringValue('own_mobile_number') ?></td>
          <td><?= $actEnt->getColumnStringValue('own_sex') ?></td>
          <td><?= $actEnt->getColumnStringValue('own_isactive') ?></td>
        </tr>
      <?php } ?>
      <tr><th class="table_add table_select" colspan="6">Přidat vlastníka</th></tr>
      </tbody>
    </table>
  </body>
</html>

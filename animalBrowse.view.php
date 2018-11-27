<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimaBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimaBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <h1>Seznam zvířat</h1>
    <form action="" method="get">
      <input type="text" value="" placeHolder="Vyhledat..." name="search">
      <input type="submit" name="searchButton" class="searchButton">
    </form>
    <table>
      <thead>
        <th>Majitel</th>
        <th>Druh</th>
        <th>Jméno</th>
        <th>Pohlaví</th>
        <th>Termín vyšetření</th>
        <th>Počet aktivních léčeb</th>
      </thead>
      <tbody>
      <tr style="color: gray"><th class="table_part" colspan="4">S plánovaným vyšetřením</th><th class="table_part">Naplánované vyšetření</th><th class="table_part"></tr>
      <?php while(($actEnt = $actVM->AnimalWithPlanedExamBrowser->getNext()) != null) { ?>
        <tr class="table_select" onclick="changePage(<?= $actEnt->getColumnStringValue('ani_pk') ?>, 'animalDetail.view.php')">
          <td><?= $actEnt->getColumnStringValue('ownername') ?></td>
          <td><?= $actEnt->getColumnStringValue('spe_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('ani_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('asex_description') ?></td>
          <td><?= $actEnt->getColumnStringValue('exabegin') ?></td>
          <td><?= $actEnt->getColumnStringValue('treatmentcnt') ?></td>
        </tr>
      <?php } ?>
      <tr style="color: gray"><th class="table_part" colspan="4">Bez plánovaného vyšetření</th><th class="table_part">Poslední vyšetření</th><th class="table_part"></tr>
      <?php while(($actEnt = $actVM->AnimalWithoutPlanedExamBrowser->getNext()) != null) { ?>
        <tr class="table_select" onclick="changePage(<?= $actEnt->getColumnStringValue('ani_pk') ?>, 'animalDetail.view.php')">
          <td><?= $actEnt->getColumnStringValue('ownername') ?></td>
          <td><?= $actEnt->getColumnStringValue('spe_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('ani_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('asex_description') ?></td>
          <td><?= $actEnt->getColumnStringValue('exabegin') ?></td>
          <td><?= $actEnt->getColumnStringValue('treatmentcnt') ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </body>
</html>

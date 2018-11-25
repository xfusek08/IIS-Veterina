<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimaBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimaBrowseViewModel");
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Styles/baseStyles.css">
    <link rel="stylesheet" type="text/css" href="Styles/aniBrowseStyle.css">
  </head>
  <body>
    <?php include 'menu.view.php';?>
    <h1>Seznam zvířat</h1>
    <input type="text" placeholder="Vyhledat..." name="">
    <table>
      <thead>
        <th>Majitel</th>
        <th>Druh</th>
        <th>Jméno</th>
        <th>Pohlaví</th>
        <th>Termín příštího vyšetření</th>
        <th>Počet aktivních léčeb</th>
      </thead>
      <tbody>
      <?php while(($actEnt = $actVM->AnimalWithPlanedExamBrowser->getNext()) != null) { ?>
        <tr pk="<?= $actEnt->getColumnStringValue('ani_pk') ?>">
          <td><?= $actEnt->getColumnStringValue('ownername') ?></td>
          <td><?= $actEnt->getColumnStringValue('spe_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('ani_name') ?></td>
          <td><?= $actEnt->getColumnStringValue('asex_description') ?></td>
          <td><?= $actEnt->getColumnStringValue('exabegin') ?></td>
          <td><?= $actEnt->getColumnStringValue('treatmentcnt') ?></td>
        </tr>
      <?php } ?>
      <tr><th colspan="7"><th></tr>
      <tr style="color: gray"><th colspan="4">Bez plánovaného vyšetření</th><th>Poslední vyšetření</th><th/></tr>
      <?php while(($actEnt = $actVM->AnimalWithoutPlanedExamBrowser->getNext()) != null) { ?>
        <tr pk="<?= $actEnt->getColumnStringValue('ani_pk') ?>">
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

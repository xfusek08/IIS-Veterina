<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalBrowseViewModel.php");
  require_once('menu.php');

  $actVM = SessionControl::pageInitRoutine("AnimalBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php BuildMenu($actVM->isAdmin) ?>
    <div class="content">
    <h1>Seznam zvířat</h1>
    <form action="" method="get">
      <input type="text" value="<?= $actVM->SearchString ?>" placeHolder="Vyhledat..." name="search">
      <input value="Vyhledat" type="submit" name="searchButton" class="searchButton">
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
      <?php foreach ($actVM->AnimalsPlanned as $actAnimal) { ?>
        <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
          <td><?= $actAnimal->OwnerName ?></td>
          <td><?= $actAnimal->Species ?></td>
          <td><?= $actAnimal->AnimalName ?></td>
          <td><?= $actAnimal->Sex ?></td>
          <td><?= $actAnimal->LatestExamination ?></td>
          <td><?= $actAnimal->TreatmentNumber ?></td>
        </tr>
      <?php } ?>
      <tr style="color: gray"><th class="table_part" colspan="4">Bez plánovaného vyšetření</th><th class="table_part">Poslední vyšetření</th><th class="table_part"></tr>
      <?php foreach ($actVM->AnimalsNotPlanned as $actAnimal ) { ?>
        <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
          <td><?= $actAnimal->OwnerName ?></td>
          <td><?= $actAnimal->Species ?></td>
          <td><?= $actAnimal->AnimalName ?></td>
          <td><?= $actAnimal->Sex ?></td>
          <td><?= $actAnimal->LatestExamination ?></td>
          <td><?= $actAnimal->TreatmentNumber ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    </div>
  </body>
</html>

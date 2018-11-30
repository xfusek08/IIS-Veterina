<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("OwnerDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/detailStyle.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <h1><?= $actVM->Name ?></h1>
      <div class="page_buttons">
        <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
        onclick="changePage(<?= $actVM->Pk ?>, 'ownerEdit.view.php')">
      </div>
      <div class="owner_detail">
        <p>Adresa: <?= $actVM->Address ?></p>
        <p>Pohlaví: <?= $actVM->Sex ?></p>
        <p>Telefonní číslo: <?= $actVM->Number ?></p>
      <div>
        <div class="animalView">
          <table>
            <thead>
              <th>Jméno</th>
              <th>Druh</th>
              <th>Pohlaví</th>
              <th>Termín vyšetření</th>
              <th>Počet aktivních léčeb</th>
            </thead>
            <tbody>
            <tr style="color: gray"><th class="table_part" colspan="3">S plánovaným vyšetřením</th><th class="table_part">Naplánované vyšetření</th><th class="table_part"></tr>
            <?php foreach ($actVM->AnimalsPlanned as $actAnimal) { ?>
              <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
                <td><?= $actAnimal->AnimalName ?></td>
                <td><?= $actAnimal->Species ?></td>
                <td><?= $actAnimal->Sex ?></td>
                <td><?= $actAnimal->LatestExamination ?></td>
                <td><?= $actAnimal->TreatmentNumber ?></td>
              </tr>
            <?php } ?>
            <tr style="color: gray"><th class="table_part" colspan="3">Bez plánovaného vyšetření</th><th class="table_part">Poslední vyšetření</th><th class="table_part"></tr>
            <?php foreach ($actVM->AnimalsNotPlanned as $actAnimal ) { ?>
              <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
                <td><?= $actAnimal->AnimalName ?></td>
                <td><?= $actAnimal->Species ?></td>
                <td><?= $actAnimal->Sex ?></td>
                <td><?= $actAnimal->LatestExamination ?></td>
                <td><?= $actAnimal->TreatmentNumber ?></td>
              </tr>
            <?php } ?>
            <tr><th class="table_add table_select" colspan="5">Přidat zvíře</th></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
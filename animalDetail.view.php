<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
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
      <div class="page_buttons">
        <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
        onclick="changePage(<?= $actVM->AnimalPk ?>, 'animalEdit.view.php')">
      </div>
      <h1>Detail zvířete</h1>
      <div class="anim_detail">
        <h3>Jméno zvířete: <?= $actVM->AnimalName ?></h3>
        <p>Jméno majitele: <?= $actVM->OwnerName ?></p>
        <p>Druh: <?= $actVM->Species ?></p>
        <p>Pohlaví: <?= $actVM->Sex ?></p>
        <p>Váha: <?= $actVM->Weight ?> kg</p>
        <p>Stav: <?= $actVM->State ?></p>
        <p>Datum narození: <?= $actVM->Birthday ?> (<?= $actVM->Age ?>)</p>
      <div class="swap_buttons">
        <input type="submit" name="submit_ch" value="Léčby" class="swap_button to_swap" onclick="swapTables(1, 2)"/>
        <input type="submit" name="submit_ch" value="Vyšetření" class="swap_button to_swap" onclick="swapTables(2, 2)"/>
      </div>
      <div id="chosen_detail_1">
        <?php $actVM->LoadTreatmentsHTML(); ?>
      </div>
      <div id="chosen_detail_2">
        <div class="examinationView">
          <h2>Vyšetření</h2>
          <table>
            <thead>
              <th>Datum</th>
              <th>Hodina</th>
              <th>Typ</th>
              <th>Trvání (min)</th>
              <th>Cena</th>
              <th>Proběhlo</th>
            </thead>
            <tbody>
              <?php foreach ($actVM->Examinations as $Examination) { ?>
                <tr class="table_select" onclick="changePage(<?= $Examination->Pk ?>, 'examinationDetail.view.php')">
                  <td><?= $Examination->Date ?></td>
                  <td><?= $Examination->BeginTime ?></td>
                  <td><?= $Examination->Type ?></td>
                  <td><?= $Examination->Duration ?></td>
                  <td><?= $Examination->Price ?></td>
                  <td><?= $Examination->Occurred ?></td>
                </tr>
              <?php } ?>
              <tr onclick="changePage(0, 'examinationEdit.view.php')"><th class="table_add table_select" colspan="6">Přidat vyšetření</th></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>

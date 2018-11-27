<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/aniStyle.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <h1><?= $actVM->AnimalName ?></h1>
      <div class="anim_detail">
        <p>Jmémo majitele: <?= $actVM->OwnerName ?></p>
        <p>Druh: <?= $actVM->Species ?></p>
        <p>Pohlaví: <?= $actVM->Sex ?></p>
        <p>Váha: <?= $actVM->Weight ?> kg</p>
        <p>Stav: <?= $actVM->State ?></p>
        <p>Datum narození: <?= $actVM->Birthday ?> (<?= $actVM->Age ?>)</p>
      <div class="swap_buttons">
        <input type="submit" name="submit_ch" value="Léčby" class="swap_button" onclick="swapTables(1)"/>
        <input type="submit" name="submit_ch" value="Vyšetření" class="swap_button" onclick="swapTables(2)"/>
      </div>
      <div id="chosen_detail_1">
        <?php $actVM->LoadTreatmentsHTML(); ?>
      </div>
      <div id="chosen_detail_2">
        <?php //$actVM->LoadMedicamentsHTML(); ?>
      </div>
    </div>
  </body>
</html>

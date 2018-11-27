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
    <link rel="stylesheet" type="text/css" href="Styles/aniDetailStyle.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <h1><?= $actVM->Animal->getColumnStringValue('ani_name') ?></h1>
    <div class="anim_detail">
      <p>Jmémo majitele: <?= $actVM->Animal->getColumnStringValue('owner_name') ?></p>
      <p>Druh: <?= $actVM->Animal->getColumnStringValue('ani_species_text') ?></p>
      <p>Pohlaví: <?= $actVM->Animal->getColumnStringValue('ani_sex_text') ?></p>
      <p>Váha: <?= $actVM->Animal->getColumnStringValue('ani_weight') ?> kg</p>
      <p>Stav: <?= $actVM->Animal->getColumnStringValue('ani_state_text') ?></p>
      <div id="age_hold">
      <div>Datum narození: <?= $actVM->Animal->getColumnStringValue('ani_birthday') ?></div>
    </div>
    <div class="swap_buttons">
      <input type="submit" name="submit_ch" value="Léčby" class="swap_button" onclick="swapTables(1)"/>
      <input type="submit" name="submit_ch" value="Vyšetření" class="swap_button" onclick="swapTables(2)"/>
    </div>
    <div class="chosen_detail">
    </div>
  </body>
</html>

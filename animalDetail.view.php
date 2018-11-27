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
    <h1><?php $actVM->animal->getColumnStringValue('ani_name') ?></h1>
    <div class="anim_detail">
      <p>Jmémo majitele: <?php $actVM->animal->getColumnStringValue('ani_owner') ?></p>
      <p>Druh: <?php $actVM->animal->getColumnStringValue('ani_species') ?></p>
      <p>Pohlaví: <?php $actVM->animal->getColumnStringValue('ani_sex') ?></p>
      <p>Váha: <?php $actVM->animal->getColumnStringValue('ani_weight') ?></p>
      <p>Stav: <?php $actVM->animal->getColumnStringValue('ani_state') ?></p>
      <p>Datum narození: <?php $actVM->animal->getColumnStringValue('ani_birthday') ?></p>
    </div>
    <div class="swap_buttons">
      <input type="submit" name="submit_ch" value="Léčby" class="swap_button" onclick="swapTables(1)"/>
      <input type="submit" name="submit_ch" value="Vyšetření" class="swap_button" onclick="swapTables(2)"/>
    </div>
    <div class="chosen_detail">
    </div>
  </body>
</html>

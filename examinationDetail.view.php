<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/ExaminationDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("ExaminationDetailViewModel");
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
      <h1><?= $actVM->ExaminationName ?></h1>
      <div class="page_buttons">
        <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button" 
        onclick="changePage(<?= $actVM->Pk ?>, 'examinationEdit.view.php')">
      </div>
      <div class="tre_detail">
        <p>Od: <?= $actVM->From ?></p>
        <p>Do: <?= $actVM->To ?></p>
        <p>Typ: <?= $actVM->Type ?></p>
        <p>Naúčtováno: <?= $actVM->Price ?></p>
        <p>Výsledná zpráva: <?= $actVM->Report ?></p>
      <div class="swap_buttons">
        <input type="submit" name="submit_ch" value="Léčby" class="swap_button" onclick="swapTables(1)"/>
        <input type="submit" name="submit_ch" value="Zahájít léčbu" class="swap_button" onclick="swapTables(2)"/>
        <input type="submit" name="submit_ch" value="Připojit k léčbě" class="swap_button" onclick="swapTables(3)"/>
        <input type="submit" name="submit_ch" value="Ukončit léčbu" class="swap_button" onclick=""/>
      </div>
      <div id="chosen_detail_1">
        
      </div>
      <div id="chosen_detail_2">
        
      </div>
      <div id="chosen_detail_3">
        
      </div>
    </div>
  </body>
</html>
<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("MedicamentDetailViewModel");
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
      <h1><?= $actVM->Name ?></h1>
      <div class="page_buttons">
        <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button" 
        onclick="changePage(<?= $actVM->Pk ?>, 'medicamentEdit.view.php')">
      </div>
      <div class="medicament_detail">
        <p>Typ: <?= $actVM->Type ?></p>
        <p>Cena: <?= $actVM->Price ?></p>
        <p>Výrobce: <?= $actVM->Producer ?></p>
        <p>Složení: <?= $actVM->Substance ?></p>
      <div>
        <?php $actVM->LoadSpeciesHTML(); ?>
      </div>
    </div>
  </body>
</html>
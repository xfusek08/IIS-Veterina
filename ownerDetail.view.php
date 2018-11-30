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
        <?php $actVM->LoadAnimalsHTML(); ?>
      </div>
    </div>
  </body>
</html>
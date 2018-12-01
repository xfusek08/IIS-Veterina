<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/employeeDetailViewModel.php");
  require_once('menu.php');

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("employeeDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/detailStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php BuildMenu(SessionControl::isAdmin()) ?>
    <div class="preContent">
      <div class="content">
        <div class="page_buttons">
          <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
          <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
          onclick="changePage(<?= $actVM->Pk ?>, 'employeeEdit.view.php')">
        </div>
        <h1>Detail zaměstnance</h1>
        <h3>Jméno zaměsnance: <?= $actVM->Name ?></h3>
        <p>Adresa: <?= $actVM->Address ?></p>
        <p>Pohlaví: <?= $actVM->Sex ?></p>
        <p>Telefoní číslo: <?= $actVM->PhoneNumber ?></p>
        <p>Hodinová mzda: <?= $actVM->Wage ?></p>
        <p>Stav: <?= $actVM->State ?></p>
        <p>Přihlašovací jméno: <?= $actVM->AccName ?></p>
    </div>
  </body>
</html>

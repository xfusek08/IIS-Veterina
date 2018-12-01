<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/employeeDetailViewModel.php");
  require_once('menu.php');

  $actVM = SessionControl::pageInitRoutine("employeeDetailViewModel.php");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/detailStyles.css">
  </head>
  <body>
    <?php BuildMenu(SessionControl::isAdmin()) ?>
    <div class="preContent">
      <div class="content">
        <div class="page_buttons">
          <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
          onclick="changePage(<?= $actVM->Pk ?>, 'optionsEdit.view.php')">
        </div>
        <h1>Vlastní nastavení</h1>
        <h2>Zaměstnanec: <?= $actVM->Name ?></h2>
        <p>Přihlašovací jméno: <?= $actVM->AccName ?></p>
      </div>
    </div>
  </body>
</html>
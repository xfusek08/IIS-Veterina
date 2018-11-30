<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OptionDetailViewModel.php");
  require_once('menu.php');

  $actVM = SessionControl::pageInitRoutine("OptionDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/detailStyles.css">
  </head>
  <body>
    <?php BuildMenu($actVM->isAdmin) ?>
    <div class="content">
      <div class="page_buttons">
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
        onclick="changePage(<?= $actVM->AnimalPk ?>, 'animalEdit.view.php')">
      </div>
      <h2>Zaměstnanec: <?= "jméno zaměstnance" ?></h2>
      <p>Jméno: <?= "přihlašovací jméno" ?></p>
      <p>Heslo: <?= "*****" ?></p>
    </div>
  </body>
</html>
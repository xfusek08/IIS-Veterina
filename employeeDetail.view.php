<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeDetailViewModel.php");
  require_once('menu.php');

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("EmployeeDetailViewModel");
  if ($actVM->Employee->Pk == 0)
    SessionControl::navigate('employeeBrowse.view.php');
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
          <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" 
          onclick="ConfirmDel('delete')">
          <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
          onclick="changePage(<?= $actVM->Employee->Pk ?>, 'employeeEdit.view.php')">
        </div>
        <h1>Detail zaměstnance</h1>
        <h3>Jméno zaměstnance: <?= $actVM->Employee->Name ?></h3>
        <p>Adresa: <?= $actVM->Employee->Address ?></p>
        <p>Pohlaví: <?= $actVM->Employee->Sex ?></p>
        <p>Telefoní číslo: <?= $actVM->Employee->Telephone ?></p>
        <p>Hodinová mzda: <?= $actVM->Employee->Wage ?></p>
        <p>Stav: <?= $actVM->Employee->State ?></p>
        <p>Přihlašovací jméno: <?= $actVM->Employee->UserName ?></p>
    </div>
  </body>
</html>

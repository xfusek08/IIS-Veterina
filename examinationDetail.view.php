<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/ExaminationDetailViewModel.php");
  require_once('menu.php');

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("ExaminationDetailViewModel");
  function treatmentCounter($i)
  {
    if($i != 0)
      return "$i" . "_";
    else
      return "";
  }
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
          onclick="changePage(<?= $actVM->Examination->Pk ?>, 'examinationEdit.view.php')">
        </div>
        <h1>Detail Vyšetření</h1>
        <p>Jméno majitele: <?= $actVM->Animal->OwnerName ?></p>
        <p>Jméno zvířete: <?= $actVM->Animal->Name ?></p>
        <p>Provedl: <?= $actVM->Employee->Surname ?></p>
        <p>Proběhlo: <?php if($actVM->Examination->Occurred == "N"){echo "Ne";}else{echo "ANO";} ?><p>
        <p>Detaily:</p>
        <table>
          <tr><td>Datum:</td><td><?= $actVM->Examination->Date ?></td></tr>
          <tr><td>Trvání:</td><td><?= $actVM->Examination->Duration ?> min</td></tr>
          <tr><td>Typ:</td><td><?= $actVM->Examination->Type ?></td></tr>
          <tr><td>Naúčtováno:</td><td><?= $actVM->Examination->Price ?></td></tr>
        </table>
        <p>Výsledná zpráva:</p>
        <textarea readonly><?= $actVM->Examination->Report ?></textarea>
        <p>Podané léky:</p>
          <table class="noHover">
          <thead>
            <th>Název</th>
            <th>Typ</th>
            <th>Výrobce</th>
            <th>Cena</th>
          </thead>
          <tbody>
            <?php foreach ($actVM->Medicaments as $med) { ?>
              <tr>
                <td><?= $med->Name ?></td>
                <td><?= $med->Type ?></td>
                <td><?= $med->Producer ?></td>
                <td><?= $med->Price ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <p>Léčby:</p>
        <?php $actVM->LoadTreatmentsHTML(); ?>
      </div>
    </div>
  </body>
</html>
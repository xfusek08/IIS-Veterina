<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentDetailViewModel.php");
  require_once('menu.php');

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("MedicamentDetailViewModel");
  if ($actVM->Pk == 0)
    SessionControl::navigate('medicamentBrowse.view.php');
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
          onclick="changePage(<?= $actVM->Pk ?>, 'medicamentEdit.view.php')">
        </div>
        <h1>Detail léku</h1>
        <div class="medicament_detail">
          <h3>Název: <?= $actVM->Name ?></h3>
          <p>Typ: <?= $actVM->Type ?></p>
          <p>Cena: <?= $actVM->Price ?></p>
          <p>Výrobce: <?= $actVM->Producer ?></p>
          <p>Složení: <?= $actVM->Substance ?></p>
        </div>
        <table class="noHover">
          <thead>
            <th>Druh</th>
            <th>Doporučená dávka</th>
            <th>Efektivní proti</th>
          </thead>
            <tbody>
              <?php foreach ($actVM->MedForSpec as $MedForSpec) { ?>
                <tr>
                  <td><?= $MedForSpec->Species ?></td>
                  <td><?= $MedForSpec->RecommendedDose ?></td>
                  <td><?= $MedForSpec->EffectiveAgainst ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
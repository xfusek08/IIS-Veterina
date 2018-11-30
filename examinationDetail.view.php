<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/ExaminationDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("ExaminationDetailViewModel");
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
      <h1>Detail Vyšetření</h1>
      <div class="page_buttons">
        <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" >
        <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
        onclick="changePage(<?= $actVM->Examination->Pk ?>, 'examinationEdit.view.php')">
      </div>
      <div class="tre_detail">
        <p>Od: <?= $actVM->Examination->BeginTime ?></p>
        <p>Do: <?= $actVM->Examination->EndTime ?> (<?= $actVM->Examination->Duration ?> min)</p>
        <p>Typ: <?= $actVM->Examination->Type ?></p>
        <p>Naúčtováno: <?= $actVM->Examination->Price ?></p>
        <p>Výsledná zpráva: <?= $actVM->Examination->Report ?></p>
      <div class="swap_buttons">
        <input type="submit" name="submit_ch" value="Léčba" class="swap_button to_swap" onclick="swapTables(1, 4)"/>
        <input type="submit" name="submit_ch" value="Zahájít léčbu" class="swap_button to_swap" onclick="swapTables(2, 4)"/>
        <input type="submit" name="submit_ch" value="Připojit k léčbě" class="swap_button to_swap" onclick="swapTables(3, 4)"/>
        <input type="submit" name="submit_ch" value="Ukončit léčbu" class="swap_button to_swap" onclick="swapTables(4, 4)"/>
      </div>
      <div id="chosen_detail_1">
        <!-- <p><?= $actVM->Treatment->Caption ?></p>
        <p>Stav: <?= $actVM->Treatment->State ?></p>
        <p>Cena: <?= $actVM->Treatment->Price ?></p>
        <div>Prognóza</div>
        <textarea readonly><?= $actVM->Treatment->Prognosis ?></textarea> -->
      </div>
      <div id="chosen_detail_2" class="hidden">
        <!-- <form action="" method="post">
          <div class="tre_detail">
            <p>Označení: <input type="text" value="<?= $actVM->Treatment->Caption ?>" name="tre_caption">
              <?= (isset($actVM->Errors['tre_caption'])) ? $actVM->Errors['tre_caption'] : '' ?>
            </p>
            <p>Stav: <input type="text" value="<?= $actVM->Treatment->State ?>" name="tre_state">
              <?= (isset($actVM->Errors['tre_state'])) ? $actVM->Errors['tre_state'] : '' ?>
            </p>
            <p>Cena: <input type="text" value="<?= $actVM->Treatment->Price ?>" name="tre_price">
              <?= (isset($actVM->Errors['tre_price'])) ? $actVM->Errors['tre_price'] : '' ?>
            </p>
            <p>Prognóza: <input type="text" value="<?= $actVM->Treatment->Prognosis ?>" name="tre_prognosis">
              <?= (isset($actVM->Errors['tre_prognosis'])) ? $actVM->Errors['tre_prognosis'] : '' ?>
            </p>
          </div>
          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
        </form> -->
      </div>
      <div id="chosen_detail_3" class="hidden">
        <!-- <?php $actVM->LoadTreatmentsHTML(); ?> -->
      </div>
      <div id="chosen_detail_4" class="hidden">
        <!-- <?php $actVM->LoadTreatmentsHTML(); ?> -->
      </div>
    </div>
  </body>
</html>
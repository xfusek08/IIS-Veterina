<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/ExaminationDetailViewModel.php");
  require_once('menu.php');

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
          <!--
          <form action="" method="post">
          <h2>Léčby</h2>
          <table>
          <thead>
            <th>Označení</th>
            <th>Stav</th>
            <th>Cena</th>
            <th>Prognóza</th>
            <th></th>
          </thead>
            <tbody id="appendTo">
              <?php $n = 0; $res = ""; foreach ($actVM->Treatments as $Treatment) { $res = treatmentCounter($n); ?>
                <tr id="TreatmentAddTo<?= $res ?>" class="template">
                  <td>
                    <input type="text" value="<?= $Treatment->Caption ?>" name="tre_caption">
                  <td>
                    <input type="text" value="<?= $Treatment->State ?>" name="tre_state">
                  </td>
                  <td>
                    <input type="text" value="<?= $Treatment->Price ?>" name="tre_price">
                  </td>
                  <td>
                    <textarea type="text" value="<?= $Treatment->Prognosis ?>" name="tre_prognosis">
                  </td>
                  <td>
                    <input type="button" name="signTo" value="Přiřadit" class="swap_button" />
                    <input type="hidden" name="<?= $res ?>tre_pk" value="<?= $Treatment->Pk ?>">
                  </td>
                </tr>
              <?php $n++; } ?>
            </tbody>
          </table>
        </form> -->
        </div>
        <div id="chosen_detail_4" class="hidden">
          <!-- 
          <form action="" method="post">
          <h2>Léčby</h2>
          <table>
          <thead>
            <th>Označení</th>
            <th>Stav</th>
            <th>Cena</th>
            <th>Prognóza</th>
            <th></th>
          </thead>
            <tbody id="appendTo">
            <?php $n = 0; $res = ""; foreach ($actVM->Treatments as $Treatment) { $res = treatmentCounter($n); ?>
                <tr id="TreatmentEnd<?= $res ?>" class="template">
                  <td>
                    <input type="text" value="<?= $Treatment->Caption ?>" name="tre_caption">
                  <td>
                    <input type="text" value="<?= $Treatment->State ?>" name="tre_state">
                  </td>
                  <td>
                    <input type="text" value="<?= $Treatment->Price ?>" name="tre_price">
                  </td>
                  <td>
                    <textarea type="text" value="<?= $Treatment->Prognosis ?>" name="tre_prognosis">
                  </td>
                  <td>
                    <input type="button" name="signTo" value="Přiřadit" class="swap_button" />
                    <input type="hidden" name="<?= $res ?>tre_pk" value="<?= $Treatment->Pk ?>">
                  </td>
                </tr>
              <?php $n++; } ?>
            </tbody>
          </table>
           -->
        </div>
      </div>
    </div>
  </body>
</html>
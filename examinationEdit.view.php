<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/ExaminationDetailViewModel.php");
  require_once('menu.php');

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("ExaminationDetailViewModel");
  function treatmentCounter($i)
  {
    if($i != 0)
      return "$i" . "_";
    else
      return "";
  }

  function buildTextInputRow($caption, $dbColNAme, $Value, $post = '') {
    global $actVM;
    ?>
    <tr>
      <th><?= $caption ?>:</th>
      <td>
        <input type="text" value="<?= $Value ?>" name="<?= $dbColNAme ?>"><?= $post ?>
        <?= (isset($actVM->Errors[$dbColNAme])) ? $actVM->Errors[$dbColNAme] : '' ?>
     </td>
    </tr>
    <?php
  }

  function buildTextRow($caption, $Value) {
    global $actVM;
    ?>
    <tr>
      <th><?= $caption ?>:</th>
      <td><?= $Value ?></td>
    </tr>
    <?php
  }

  function buildSelectRow($caption, $dbColNAme, $selectArray, $selValue, $post = '') {
    global $actVM;
    ?>
    <tr>
      <th><?= $caption ?>:</th>
      <td>
        <select type="text" name="<?= $dbColNAme ?>">
          <?php foreach($selectArray as $key => $value) {?>
            <option value="<?= $key ?>" <?php if ($selValue == $value) echo "selected" ?>> <?= $value ?></option>
          <?php } ?>
        </select>
        <?= $post ?>
      </td>
    </tr>
    <?php
  }

  function buildCheckBoxRow($caption, $dbColNAme, $Value, $post = '') {
    global $actVM;
    ?>
    <tr>
      <th><?= $caption ?>:</th>
      <td>
        <input type="checkbox" <?= ($Value) ? 'checked="checked"' : "" ?> name="<?= $dbColNAme ?>" ><?= $post ?>
        <?= (isset($actVM->Errors[$dbColNAme])) ? $actVM->Errors[$dbColNAme] : '' ?>
     </td>
    </tr>
    <?php
  }

  function getprefix($i) {
    if($i != 0)
      return "$i" . "_";
    else
      return "";
  }

  function buildMOESlect($prefix, $medpk) {
    global $actVM;
    ?>
    <table>
      <td>
        <select type="text" name="<?= $prefix . 'med_pk' ?>">
          <?php foreach($actVM->MedicamentSelect as $key => $value) {?>
            <option value="<?= $key ?>" <?php if ($medpk == $key) echo "selected" ?>> <?= $value ?></option>
          <?php } ?>
        </select>
      </td>
      <td>
        <input type="button" name="delete" value="Smazat" class="swap_button"/>
      </td>
    </table>
    <?php
  }
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/editStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php BuildMenu(SessionControl::isAdmin()) ?>
    <div class="preContent">
      <div class="content">
        <div class="page_buttons">
          <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->Examination->Pk ?>, 'examinationDetail.view.php')">
        </div>
        <form action="" method="post">
          <h1>Vyšetření</h1>
          <div class="block">
            <table class="edit_table">
              <?php      buildTextRow('Majitel',         $actVM->Animal->OwnerName) ?>
              <?php      buildTextRow('Zvíře',           $actVM->Animal->Name . ' ' . $actVM->Animal->Species . ' ' . $actVM->Animal->Race) ?>
              <?php      buildTextRow('Provedl',         $actVM->Employee->Surname . ' ' . $actVM->Employee->Name) ?>
              <?php buildTextInputRow('Datum',           'exa_begin_date_time', $actVM->Examination->Date) ?>
              <?php buildTextInputRow('Délka vyšetření', 'exa_duration_minutes', $actVM->Examination->Duration, ' minut') ?>
              <?php    buildSelectRow('Typ',             'exa_type', $actVM->ExaminationTypeSelect, $actVM->Examination->Type) ?>
              <?php buildTextInputRow('Naúčtováno',      'exa_price', $actVM->Examination->Price) ?>
              <?php  buildCheckBoxRow('Proběhlo',        'exa_occurred', $actVM->Examination->Occurred) ?>
            </table>
          </div>

          <h3>Výsledná zpráva:</h3>
          <textarea name="" ><?= $actVM->Examination->Report ?></textarea>

          <h3>Podané léky:</h3>
          <div>(zadávejte prosím unikátní hodnoty léků)</div>
          <div id="moeStack">
          <?php $n = 0; foreach ($actVM->Medicaments as $med) {  $prefix = getprefix($n); ?>
            <div class="moerow"><?php buildMOESlect($prefix, $med->Pk) ?></div>
          <?php } ?>
          </div>

          <input type="hidden" name="moeCount" value="<?= count($actVM->Medicaments) ?>">

          <input type="button" name="delete" value="Přidat" class="swap_button" onclick="addRow('#moeTamplate', 'moeStack', 'input[name=moeCount]'), 'select[name=med_pk]'"/>

          <h3>Léčby:</h3>

          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
        </form>
        <div class="message"><?= $actVM->Message ?></div>

      </div>
    </div>
    <div id="moeTamplate" class="moerow hidden">
      <?php buildMOESlect('', 0) ?>
    </div>
  </body>
</html>
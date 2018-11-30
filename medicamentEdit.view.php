<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentDetailViewModel.php");
  require_once('menu.php');

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("MedicamentDetailViewModel");

  function medForSpecCounter($i)
  {
    if(n != 0)
      return "$i";
    else 
      return "";
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
    <div class="content">
      <div class="page_buttons">
        <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->Pk ?>, 'medicamentDetail.view.php')">
      </div>
      <form action="" method="post">
        <h1>Lék:</h1>
        <div class="block">
          <table class="edit_table">
            <tr>
              <th>Jméno:</th>
              <td>
                <input type="text" value="<?= $actVM->Name ?>" name="med_name">
                <?= (isset($actVM->Errors['med_name'])) ? $actVM->Errors['med_name'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Cena:</th>
              <td>
                <input type="text" value="<?= $actVM->Price ?>" name="med_price">
                <?= (isset($actVM->Errors['med_price'])) ? $actVM->Errors['med_price'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Typ:</th>
              <td>
                <select type="text" name="med_type">
                <?php foreach($actVM->TypeSelect as $key => $value) { ?>
                <option value="<?= $key ?>"
                        <?php if ($actVM->Type == $value) echo "selected" ?> >
                  <?= $value ?>
                </option>
                <?php } ?>
                </select>
                <?= (isset($actVM->Errors['med_type'])) ? $actVM->Errors['med_type'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Výrobce:</th>
              <td>
                <input type="text" value="<?= $actVM->Producer ?>" name="med_producer">
                <?= (isset($actVM->Errors['med_producer'])) ? $actVM->Errors['med_producer'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Složení:</th>
              <td>
                <input type="text" value="<?= $actVM->Substance ?>" name="med_substance">
                <?= (isset($actVM->Errors['med_substance'])) ? $actVM->Errors['med_substance'] : '' ?>
              </td>
            </tr>
          </table>
        </div>
        <table>
        <thead>
          <th>Druh</th>
          <th>Doporučená dávka</th>
          <th>Efektivní proti</th>
        </thead>
          <tbody>
            <?php $n = 0; foreach ($actVM->MedForSpec as $MedForSpec) { $res = medForSpecCounter($n); ?>
              <tr id="MedForSpecEditFormTemp" class="template">
                <td>
                  <select type="text" name="<?= $res ?>mfs_spepk">
                    <?php foreach($actVM->SpeciesSelect as $key => $value) {?>
                    <option value="<?=  $key ?>"<?php if ($MedForSpec->SpeciesPK == $value) echo "selected" ?> > <?= $value ?>
                    </option> <?php } ?>
                  </select>
                  <?= (isset($actVM->Errors[$res + 'mfs_spepk'])) ? $actVM->Errors[$res + 'mfs_spepk'] : '' ?>
                </td>
                <td>
                  <input type="text" value="<?= $MedForSpec->RecommendedDose ?>" name="<?= $res ?>mfs_dose">
                  <?= (isset($actVM->Errors[$res + 'mfs_dose'])) ? $actVM->Errors[$res + 'mfs_dose'] : '' ?> 
                <td>
                  <input type="text" value="<?= $MedForSpec->EffectiveAgainst ?>" name="<?= $res ?>mfs_against">
                  <?= (isset($actVM->Errors[$res + 'mfs_against'])) ? $actVM->Errors[$res + 'mfs_against'] : '' ?> 
                </td>
                <td>
                  <input type="button" name="delete" value="Smazat" class="swap_button" />
                  <input type="hidden" name="mfsPk" value="<?= $MedForSpec->Pk ?>">
                </td>
              </tr>
            <?php $n++; } ?>
          </tbody>
        </table>
        <input type="button" name="add" class="swap_button add_button" value="Přidat k druhu" onclick="addRow()">
        <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
        <input type="hidden" name="medCount" value="<?= count($actVM->MedForSpec) ?>">
      </form>
    </div>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>
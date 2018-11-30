<?php
  ini_set("default_charset", "utf-8");
  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentDetailViewModel.php");
  require_once('menu.php');
  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("MedicamentDetailViewModel");
  function medForSpecCounter($i)
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
          <th></th>
        </thead>
          <tbody id="appendTo">
            <?php $n = 0; $res = ""; foreach ($actVM->MedForSpec as $MedForSpec) { $res = medForSpecCounter($n); ?>
              <tr id="MedForSpecEditFormTemp<?= $res ?>" class="template">
                <td>
                  <select type="text" name="<?= $res ?>mfs_spepk">
                    <?php foreach($actVM->SpeciesSelect as $key => $value) {?>
                    <option value="<?=  $key ?>"<?php if ($MedForSpec->SpeciesPK == $key) echo "selected" ?> > <?= $value ?>
                    </option> <?php } ?>
                  </select>
                  <?= (isset($actVM->Errors[$res . 'mfs_spepk'])) ? $actVM->Errors[$res . 'mfs_spepk'] : '' ?>
                </td>
                <td>
                  <input type="text" value="<?= $MedForSpec->RecommendedDose ?>" name="<?= $res ?>mfs_recommended_dosis">
                  <?= (isset($actVM->Errors[$res . 'mfs_recommended_dosis'])) ? $actVM->Errors[$res . 'mfs_recommended_dosis'] : '' ?>
                <td>
                  <input type="text" value="<?= $MedForSpec->EffectiveAgainst ?>" name="<?= $res ?>mfs_effective_against">
                  <?= (isset($actVM->Errors[$res . 'mfs_effective_against'])) ? $actVM->Errors[$res . 'mfs_effective_against'] : '' ?>
                </td>
                <td>
                  <input type="button" name="delete" value="Smazat" class="swap_button" />
                  <input type="hidden" name="<?= $res ?>mfs_pk" value="<?= $MedForSpec->Pk ?>">
                  <input type="hidden" name="<?= $res ?>mfs_medpk" value="<?= $actVM->Pk ?>">
                </td>
              </tr>
            <?php $n++; } ?>
          </tbody>
        </table>
        <input type="button" name="add" class="swap_button bigger_button" value="Přidat k druhu" onclick="addRow()">
        <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
        <input type="hidden" name="medCount" value="<?= count($actVM->MedForSpec) ?>">
      </form>
    </div>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>
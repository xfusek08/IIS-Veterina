<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");
  require_once('menu.php');

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
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
        <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->AnimalPk ?>, 'animalDetail.view.php')">
      </div>
      <form action="" method="post">
        <h1>Zvíře</h1>
        <div class="block">
          <table class="edit_table">
            <tr>
              <th>Jméno zvířete:</th>
              <td><input type="text" value="<?= $actVM->AnimalName ?>" name="ani_name">
              <?= (isset($actVM->Errors['ani_name'])) ? $actVM->Errors['ani_name'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Majitel:</th>
              <td><?= $actVM->OwnerName ?></td>
            </tr>
            <tr>
              <th>Druh:</th>
              <td><select type="text" name="ani_species">
                <?php foreach($actVM->SpeciesSelect as $key => $value) {?>
                <option value="<?=  $key ?>"<?php if ($actVM->Species == $value) echo "selected" ?> > <?= $value ?>
                </option> <?php } ?> </select>
              <?= (isset($actVM->Errors['ani_species'])) ? $actVM->Errors['ani_species'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Rasa:</th>
              <td>
                <input type="text" value="<?= $actVM->Race ?>" name="ani_race"><?= (isset($actVM->Errors['ani_name'])) ? $actVM->Errors['ani_race'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Pohlaví:</th>
              <td><select type="text" name="ani_sex">
                <?php foreach($actVM->SexSelect as $key => $value) {?>
                <option value="<?= $key ?>" <?php if ($actVM->Sex == $value) echo "selected" ?> > <?= $value ?>
                </option>
                <?php } ?>
              </select>
              <?= (isset($actVM->Errors['ani_sex'])) ? $actVM->Errors['ani_sex'] : '' ?></td>
            </tr>
            <tr>
              <th>Váha:</th>
              <td><input type="text" value="<?= $actVM->Weight ?>" name="ani_weight"> kg
                <?= (isset($actVM->Errors['ani_weight'])) ? $actVM->Errors['ani_weight'] : '' ?></td>
            </tr>
              <th>Stav:</th>
              <td><select type="text" name="ani_state">
                  <?php foreach($actVM->StateSelect as $key => $value) {?>
                  <option value="<?= $key ?>" <?php if ($actVM->State == $value) echo "selected" ?> > <?= $value ?>
                  </option>
                  <?php } ?>
                </select>
                <?= (isset($actVM->Errors['ani_state'])) ? $actVM->Errors['ani_state'] : '' ?></td>
            <tr>
            </tr>
            <tr>
              <th>Datum narození:</th>
              <td><input type="text" value="<?= $actVM->Birthday ?>" name="ani_birthday">
                <?= (isset($actVM->Errors['ani_birthday'])) ? $actVM->Errors['ani_birthday'] : '' ?></td>
            </tr>
          </table>
        </div>
        <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
      </form>
      <div class="message"><?= $actVM->Message ?></div>
    </div>
  </body>
</html>

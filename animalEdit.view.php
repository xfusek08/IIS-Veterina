<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

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
    <?php include 'menu.php';?>
    <div class="content">
      <form action="" method="post">
        <h1><?= $actVM->AnimalName ?></h1>
        <div class="block">
          <div class="anim_detail">
            <p>Jméno zvířete:</p>
            <p>Majitel:</p>
            <p>Druh:</p>
            <p>Rasa:</p>
            <p>Pohlaví:</p>
            <p>Váha:</p>
            <p>Stav:</p>
            <p>Datum narození:</p>
          </div>
          <div>
            <p><input type="text" value="<?= $actVM->AnimalName ?>" name="ani_name">
              <?= (isset($actVM->Errors['ani_name'])) ? $actVM->Errors['ani_name'] : '' ?></p>
            <p><?= $actVM->OwnerName ?></p>
            <p><select type="text" name="ani_species">
                <?php foreach($actVM->SpeciesSelect as $key => $value) {?>
                <option value="<?=  $key ?>"
                        <?php if ($actVM->Species == $value) echo "selected" ?> >
                  <?= $value ?>
                </option>
                <?php } ?>
              </select>
              <?= (isset($actVM->Errors['ani_species'])) ? $actVM->Errors['ani_species'] : '' ?></p>
            <p><input type="text" value="<?= $actVM->Race ?>" name="ani_race"><?= (isset($actVM->Errors['ani_name'])) ? $actVM->Errors['ani_race'] : '' ?></p>
            <p><select type="text" name="ani_sex">
                <?php foreach($actVM->SexSelect as $key => $value) {?>
                <option value="<?= $key ?>"
                        <?php if ($actVM->Sex == $value) echo "selected" ?> >
                  <?= $value ?>
                </option>
                <?php } ?>
              </select>
              <?= (isset($actVM->Errors['ani_sex'])) ? $actVM->Errors['ani_sex'] : '' ?></p>
            <p><input type="text" value="<?= $actVM->Weight ?>" name="ani_weight"> kg
              <?= (isset($actVM->Errors['ani_weight'])) ? $actVM->Errors['ani_weight'] : '' ?></p>
            <p><select type="text" name="ani_state">
                <?php foreach($actVM->StateSelect as $key => $value) {?>
                <option value="<?= $key ?>"
                        <?php if ($actVM->State == $value) echo "selected" ?> >
                  <?= $value ?>
                </option>
                <?php } ?>
              </select>
              <?= (isset($actVM->Errors['ani_state'])) ? $actVM->Errors['ani_state'] : '' ?></p>
            <p><input type="text" value="<?= $actVM->Birthday ?>" name="ani_birthday">
              <?= (isset($actVM->Errors['ani_birthday'])) ? $actVM->Errors['ani_birthday'] : '' ?></p>
          </div>
        </div>
        <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
      </form>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>

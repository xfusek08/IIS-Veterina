<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/AnimalDetailViewModel.php");

  $actVM = SessionControl::pageInitRoutine("AnimalDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/aniStyle.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <form action="" method="post">
        <h1><?= $actVM->AnimalName ?></h1>
        <div class="anim_detail">
          <p>Jmémo: <input type="text" value="<?= $actVM->AnimalName ?>" name="AnimalName"></p>
          <p>Jmémo majitele: <input type="text" value="<?= $actVM->OwnerName ?>" name="OwnerName"></p>
          <p>Druh: <input type="text" value="<?= $actVM->Species ?>" name="Species">
            <select type="text" name="Species">
              <?php //while() ?>
            </select>
          </p>
          <p>Pohlaví:
            <select type="text" name="Sex">
              <option value="Samec" <?php if($actVM->Sex == "Samec"){echo "selected";} ?> >Samec</option>
              <option value="Samice" <?php if($actVM->Sex == "Samice"){echo "selected";} ?> >Samice</option>
            </select>
          </p>
          <p>Váha: <input type="text" value="<?= $actVM->Weight ?>" name="Weight"> kg</p>
          <p>Stav:
            <select type="text" name="State">
              <option value="Aktivní" <?php if($actVM->State == "Aktivní"){echo "selected";} ?> >Aktivní</option>
              <option value="Neaktivní" <?php if($actVM->State == "Neaktivní"){echo "selected";} ?> >Neaktivní</option>
              <option value="Mrtvé" <?php if($actVM->State == "Mrtvé"){echo "selected";} ?> >Mrtvé</option>
            </select>
          </p>
          <p>Datum narození: <input type="text" value="<?= $actVM->Birthday ?>" name="Birthday"></p>
        </div>
          <input type="submit" action="" name="submit_sav" value="Uložit" class="swap_button" />
      </form>
    </div>
  </body>
</html>

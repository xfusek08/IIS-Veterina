<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentDetailViewModel.php");

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("MedicamentDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <form action="" method="post">
        <h1><?= $actVM->Name ?></h1>
        <div class="medm_detail">
          <p>Jméno: <input type="text" value="<?= $actVM->Name ?>" name="med_name">
            <?= (isset($actVM->Errors['med_name'])) ? $actVM->Errors['med_name'] : '' ?>
          </p>
          <p>Cena: <input type="text" value="<?= $actVM->Price ?>" name="med_price">
            <?= (isset($actVM->Errors['med_price'])) ? $actVM->Errors['med_price'] : '' ?>
          </p>
          <p>Typ:
            <select type="text" name="med_type">
              <?php foreach($actVM->SexSelect as $key => $value) {?>
              <option value="<?= $key ?>"
                      <?php if ($actVM->Sex == $value) echo "selected" ?> >
                <?= $value ?>
              </option>
              <?php } ?>
            </select>
            <?= (isset($actVM->Errors['med_type'])) ? $actVM->Errors['med_type'] : '' ?>
          </p>
          <p>Výrobce: <input type="text" value="<?= $actVM->Producer ?>" name="med_producer">
            <?= (isset($actVM->Errors['med_producer'])) ? $actVM->Errors['med_producer'] : '' ?>
          </p>
          <p>Složení: <input type="text" value="<?= $actVM->Substance ?>" name="med_substance">
            <?= (isset($actVM->Errors['med_substance'])) ? $actVM->Errors['med_substance'] : '' ?>
          </p>
        </div>
          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
      </form>
    </div>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>
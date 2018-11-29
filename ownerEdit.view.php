<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerDetailViewModel.php");

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("OwnerDetailViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/ownStyle.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <form action="" method="post">
        <h1><?= $actVM->Name ?></h1>
        <div class="ownm_detail">
          <p>Jméno: <input type="text" value="<?= $actVM->Firstname ?>" name="own_name">
            <?= (isset($actVM->Errors['own_name'])) ? $actVM->Errors['own_name'] : '' ?>
          </p>
          <p>Příjmení: <input type="text" value="<?= $actVM->Surname ?>" name="own_surname">
            <?= (isset($actVM->Errors['own_surname'])) ? $actVM->Errors['own_surname'] : '' ?>
          </p>
          <p>Adresa: <input type="text" value="<?= $actVM->Address ?>" name="own_address">
            <?= (isset($actVM->Errors['own_address'])) ? $actVM->Errors['own_address'] : '' ?>
          </p>
          <p>Pohlaví:
            <select type="text" name="own_sex">
              <?php foreach($actVM->SexSelect as $key => $value) {?>
              <option value="<?= $key ?>"
                      <?php if ($actVM->Sex == $value) echo "selected" ?> >
                <?= $value ?>
              </option>
              <?php } ?>
            </select>
            <?= (isset($actVM->Errors['own_sex'])) ? $actVM->Errors['own_sex'] : '' ?>
          </p>
          <p>Telefoní číslo: <input type="text" value="<?= $actVM->Number ?>" name="own_mobile_number">
            <?= (isset($actVM->Errors['own_mobile_number'])) ? $actVM->Errors['own_mobile_number'] : '' ?>
          </p>
        </div>
          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
      </form>
    </div>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>
<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerDetailViewModel.php");
  require_once('menu.php');

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("OwnerDetailViewModel");
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
        <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->Pk ?>, 'ownerDetail.view.php')">
      </div>
      <form action="" method="post">
        <h1>Majitel</h1>
        <div class="block">
          <table class="edit_table">
            <tr>
              <th>Jméno:</th>
              <td>
                <input type="text" value="<?= $actVM->Firstname ?>" name="own_name">
                <?= (isset($actVM->Errors['own_name'])) ? $actVM->Errors['own_name'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Příjmení:</th>
              <td>
                <input type="text" value="<?= $actVM->Surname ?>" name="own_surname">
                <?= (isset($actVM->Errors['own_surname'])) ? $actVM->Errors['own_surname'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Adresa:</th>
              <td>
                <input type="text" value="<?= $actVM->Address ?>" name="own_address">
                <?= (isset($actVM->Errors['own_address'])) ? $actVM->Errors['own_address'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Pohlaví:</th>
              <td>
                <select type="text" name="own_sex">
                <?php foreach($actVM->SexSelect as $key => $value) {?>
                <option value="<?= $key ?>"
                        <?php if ($actVM->Sex == $value) echo "selected" ?> >
                  <?= $value ?>
                </option>
                <?php } ?>
                </select>
                <?= (isset($actVM->Errors['own_sex'])) ? $actVM->Errors['own_sex'] : '' ?>
              </td>
            </tr>
            <tr>
              <th>Telefoní číslo:</th>
              <td>
                <input type="text" value="<?= $actVM->Number ?>" name="own_mobile_number">
                <?= (isset($actVM->Errors['own_mobile_number'])) ? $actVM->Errors['own_mobile_number'] : '' ?>
              </td>
            </tr>
          </table>
          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
      </form>
    </div>
    <div class="message"><?= $actVM->Message ?></div>
  </body>
</html>
<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeDetailViewModel.php");
  require_once('menu.php');

  $_GET['edit'] = '';
  $actVM = SessionControl::pageInitRoutine("EmployeeDetailViewModel");
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
          <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->Pk ?>, 'employeeDetail.view.php')">
        </div>
        <form action="" method="post">
          <h1>Zaměstnanec</h1>
          <div class="block">
            <table class="edit_table">
              <tr>
                <th>Jméno zaměsnance:</th>
                <td><input type="text" value="<?= $actVM->Firstname ?>" name="emp_name">
                <?= (isset($actVM->Errors['emp_name'])) ? $actVM->Errors['emp_name'] : '' ?>
                </td>
              </tr>
              <tr>
                <th>Přijmení zaměsnance:</th>
                <td><input type="text" value="<?= $actVM->Surname ?>" name="emp_surname">
                <?= (isset($actVM->Errors['emp_surname'])) ? $actVM->Errors['emp_surname'] : '' ?>
                </td>
              </tr>
              <tr>
                <th>Adresa:</th>
                <td><input type="text" value="<?= $actVM->Address ?>" name="emp_address">
                <?= (isset($actVM->Errors['emp_address'])) ? $actVM->Errors['emp_address'] : '' ?>
                </td>
              </tr>
              <tr>
                <th>Pohlaví:</th>
                <td><select type="text" name="emp_sex">
                  <?php foreach($actVM->SexSelect as $key => $value) {?>
                  <option value="<?= $key ?>" <?php if ($actVM->Sex == $value) echo "selected" ?> > <?= $value ?>
                  </option>
                  <?php } ?>
                </select>
                <?= (isset($actVM->Errors['emp_sex'])) ? $actVM->Errors['emp_sex'] : '' ?></td>
              </tr>
              <tr>
                <th>Telefoní číslo:</th>
                <td><input type="text" value="<?= $actVM->PhoneNumber ?>" name="emp_mobile_number"> kg
                  <?= (isset($actVM->Errors['emp_mobile_number'])) ? $actVM->Errors['emp_mobile_number'] : '' ?></td>
              </tr>
              <tr>
                <th>Hodinová mzda:</th>
                <td><input type="text" value="<?= $actVM->Wage ?>" name="emp_wage">
                <?= (isset($actVM->Errors['emp_wage'])) ? $actVM->Errors['emp_wage'] : '' ?>
                </td>
              </tr>
              <tr>
                <th>Stav:</th>
                <td><select type="text" name="emp_state">
                    <?php foreach($actVM->StateSelect as $key => $value) {?>
                    <option value="<?= $key ?>" <?php if ($actVM->State == $value) echo "selected" ?> > <?= $value ?>
                    </option>
                    <?php } ?>
                  </select>
                  <?= (isset($actVM->Errors['emp_state'])) ? $actVM->Errors['emp_state'] : '' ?></td>
              </tr>
              <tr>
                <th>Přihlašovací jméno:</th>
                <td><input type="text" value="<?= $actVM->AccName ?>" name="emp_username">
                  <?= (isset($actVM->Errors['emp_username'])) ? $actVM->Errors['emp_username'] : '' ?></td>
              </tr>
            </table>
          </div>
          <input type="submit" name="post_submit" value="Uložit" class="swap_button" />
        </form>
        <div class="message"><?= $actVM->Message ?></div>
      </div>
    </div>
  </body>
</html>

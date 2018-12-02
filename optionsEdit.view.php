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
          <input type="submit" value="Zpět" name="back" class="swap_button" onclick="changePage(<?= $actVM->Pk ?>, 'optionsDetail.view.php')">
        </div>
        <form action="" method="post">
          <h1>Zaměstnanec</h1>
          <div class="block">
            <table class="edit_table">
              <h1>Nastavení</h1>
              <tr>
                <th>Přihlašovací jméno:</th>
                <td><input type="text" value="<?= $actVM->AccName ?>" name="emp_username">
                  <?= (isset($actVM->Errors['emp_username'])) ? $actVM->Errors['emp_username'] : '' ?></td>
              </tr>
              <tr>
                <th>Heslo:</th>
                <td><input type="password" value="<?= $actVM->Password ?>" name="emp_password">
                  <?= (isset($actVM->Errors['emp_password'])) ? $actVM->Errors['emp_password'] : '' ?></td>
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
<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/LoginViewModel.php");

  // can't do pageInitRoutine - don't want to check if user is logged
  SessionControl::startSession();
  if (SessionControl::isLogged())
    SessionControl::navigate(MAIN_PAGE);
  $actVM = SessionControl::initViewModel("LoginViewModel");
?>

<html>
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="Styles/baseStyles.css">
  <link rel="stylesheet" type="text/css" href="Styles/loginStyle.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <h1>Přihlášení</h1>
    <form method="post">
      <table>
        <tr>
          <td>Jméno:</td>
          <td><input name="name" type="text" value="<?= $actVM->Name ?>"/></td>
        </tr>
        <tr>
          <td>Heslo:</td>
          <td><input name="psw" type="password"/></td>
        </tr>
      </table>
      <div>
        <input type="submit" name="post_submit" value="Přihlásit" class="log_button"/>
      </div>
    </form>
    <hr>
    <div><?= $actVM->Message ?></div>
  </body>
</html>

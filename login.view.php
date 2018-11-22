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

<!-- TODO: headers -->
<html>
  <head>
  <!-- TODO: headers -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <h1>Přihlášení</h1>
    <form method="post">
      <table>
        <tr>
          <td>Jméno:</td>
          <td><input name="name" type="text" value="<?= $actVM->name ?>"/></td>
        </tr>
        <tr>
          <td>Heslo:</td>
          <td><input name="psw" type="password"/></td>
        </tr>
      </table>
      <div>
        <input type="submit" name="post_submit" value="Přihlásit"/>
      </div>
    </form>
    <hr>
    <div><?= $actVM->message ?></div>
  </body>
</html>

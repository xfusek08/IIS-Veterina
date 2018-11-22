<?php
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
  </head>
  <body>
    login
  </body>
</html>

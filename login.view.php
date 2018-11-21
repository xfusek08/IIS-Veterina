<?php
  require_once("php/SessionControl.php");
  require_once("viewModels/login.vm.php");

  SessionControl::destroySession();
  SessionControl::startSession();
?>

<html>
<body>
login
</body>
</html>

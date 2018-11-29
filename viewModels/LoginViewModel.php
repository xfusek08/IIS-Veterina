<?php

require_once("viewModels/base/ViewModelBase.php");

class LoginViewModel extends ViewModelBase {
  public $Name = "";
  public $Message = "";

  public function ProcessGet() {
    $this->Message = "";
    if (isset($_GET["message"])) {
      $this->Message = urldecode($_GET["message"]);
    }
  }

  public function processAjax() {}

  public function processPost() {
    if (isset($_POST["name"]) && isset($_POST["psw"])) {
      $this->Name = $_POST["name"];
      $psw = $_POST["psw"];

      if ($this->Name == "" || $psw == "") {
        $this->Message = "Jméno a heslo nesmí být prázdné.";
      } else if (SessionControl::login($this->Name, $psw)) {
        SessionControl::navigate(MAIN_PAGE);
      } else {
        $this->Message = "Chybný uživatel.";
      }
    } else
      $this->Message = "Chybná data.";
  }
}

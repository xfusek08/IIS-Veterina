<?php
require_once("lib/Database.php");
require_once("viewModels/ViewModelBase.php");

class LoginViewModel extends ViewModelBase {
  public $name = "";
  public $message = "";

  public function loadFromGet() {
    $this->message = "";
    if (isset($_GET["message"])) {
      $this->message = urldecode($_GET["message"]);
    }
  }

  public function processAjax() {}

  public function processPost() {
    if (isset($_POST["name"]) && isset($_POST["psw"])) {
      $this->name = $_POST["name"];
      $psw = $_POST["psw"];

      if ($this->name == "" || $psw == "") {
        $this->message = "Jméno a heslo nesmí být prázdné.";
      } else if (SessionControl::login($this->name, $psw)) {
        SessionControl::navigate(MAIN_PAGE);
      } else {
        $this->message = "Chybný uživatel.";
      }
    } else
      $this->message = "Chybná data.";
  }
}

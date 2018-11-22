<?php

require_once("viewModels/ViewModelBase.php");
require_once("models/AnimalModel.php");

class AnimalDetailViewModel extends ViewModelBase {
  public $isEdit;
  public $animal = null;
  public $treatments = array();

  public function __construct() {
    $this->isEdit = false;
    $this->animal = new AnimalModel();
  }

  public function loadFromGet() {
    if (isset($_GET['pk'])) {
      // TODO: Load by pk
      if (isset($_GET['edit'])) {
        $this->isEdit = true;
      }
    }
  }

  public function processAjax() {}

  public function processPost() {}
}

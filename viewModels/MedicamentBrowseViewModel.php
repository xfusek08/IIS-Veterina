<?php

require_once("viewModels/ViewModelBase.php");

class MedicamentBrowseViewModel extends ViewModelBase {
  public $Medicaments = array();  // probably just result of concrete sql

  public function loadFromGet() {}

  public function processAjax() {}

  public function processPost() {}
}

<?php

require_once("viewModels/ViewModelBase.php");

class OwnerBrowseViewModel extends ViewModelBase {
  public $Owners = array(); // probably just result of concrete sql

  public function loadFromGet() {}

  public function processAjax() {}

  public function processPost() {}
}

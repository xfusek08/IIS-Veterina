<?php

require_once("viewModels/ViewModelBase.php");

class EmployeeBrowseViewModel extends ViewModelBase {
  public $Employees = array();  // probably just result of concrete sql

  public function loadFromGet() {}

  public function processAjax() {}

  public function processPost() {}
}

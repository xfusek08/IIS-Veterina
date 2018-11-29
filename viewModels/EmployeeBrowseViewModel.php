<?php

require_once("viewModels/base/ViewModelBase.php");

class EmployeeBrowseViewModel extends ViewModelBase {
  public $Employees = array();  // probably just result of concrete sql

  public function ProcessGet() {}

  public function processAjax() {}

  public function processPost() {}
}

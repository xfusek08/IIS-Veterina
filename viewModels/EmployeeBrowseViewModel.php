<?php

require_once("viewModels/base/ViewModelBase.php");

class EmployeeBrowseViewModel extends ViewModelBase {
  public $Employees = array();  // probably just result of concrete sql

  public $SearchString = "";

  public function ProcessGet() {}

  public function processAjax() {}

  public function processPost() {}

  public function initView() {
  }

  public function onSuccessPost() {
  }

  public function initEdit() {
  }
}

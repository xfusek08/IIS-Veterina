<?php

require_once("viewModels/base/ViewModelBase.php");
require_once("viewModels/base/EditableDetailViewModelBase.php");

class EmployeeDetailViewModel extends EditableDetailViewModelBase {
  public $Pk = 0;
  public $Name = "";
  public $Firstname = "";
  public $Surname = "";
  public $Address = "";
  public $Sex = "";
  public $PhoneNumber = "";
  public $Position = "";
  public $Wage = "";
  public $State = "";
  public $AccName = "";
  public $Password = "";
  
  public $SexSelect = array();
  public $StateSelect = array();

  public function __construct() {
  }

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

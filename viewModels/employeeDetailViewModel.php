<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/EmployeeEntity.php");

require_once("models/EmployeeModel.php");

require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class EmployeeDetailViewModel extends EditableDetailViewModelBase {
  public $Employee = null; // EmployeeModel

  public $SexSelect = array();
  public $StateSelect = array();
  public $PositionSelect = array();

  public function __construct() {
    $this->Employee = new EmployeeModel();
    parent::__construct('EmployeeEntity');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->SexSelect      = $this->LoadEditSelectData("select psex_shortcut, psex_text from Person_sex order by psex_order");
    $this->StateSelect    = $this->LoadEditSelectData("select est_shortcut, est_text from Employee_state order by est_text");
    $this->PositionSelect = $this->LoadEditSelectData("select pos_shortcut, pos_text from Employee_position order by pos_text");
    $this->loadData();
  }

  public function loadData() {
    $this->Employee = Mapper::entityToEmployeeModel($this->MainDBEntity);
  }

  public function onSuccessPost() {
    SessionControl::navigate("employeeDetail.view.php?pk=" . $this->MainDBEntity->Pk);
  }

  public function onSuccessDelete() {
    SessionControl::navigate("employeeBrowser.view.php");
  }
}

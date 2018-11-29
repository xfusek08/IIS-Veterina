<?php

require_once("lib/DBEntityBrowser.php");

require_once("models/ExaminationModel.php");

require_once("DBEntities/ExaminationEntity.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class ExaminationsOnAnimalViewModel extends EditableDetailViewModelBase {
  public $Examinations = array(); // array of ExaminationModel

  public function __construct() {
    parent::__construct('ExaminationEntity', 'treatmentsOnAnimal.view.php');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() { }

  public function onSuccessPost() { }

  public function loadData() {
  }
}
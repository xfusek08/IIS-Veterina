<?php

require_once("DBEntities/ExaminationEntity.php");

require_once("models/ExaminationModel.php");
require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class ExaminationDetailViewModel extends EditableDetailViewModelBase {
  public $Examination = null; // instance of ExaminationModel

  public function __construct() {
    parent::__construct('ExaminationEntity');

    $this->Examination = new ExaminationModel();
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->loadData();
  }

  public function loadData() {
    $this->Examination = Mapper::entityToExaminationModel($this->MainDBEntity);
  }

  public function onSuccessPost() {
    SessionControl::navigate("examinationDetail.view.php?pk=" . $this->MainDBEntity->Pk);
  }

  public function onSuccessDelete() {  }
}

<?php

require_once("DBEntities/MedicamentEntity.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");
require_once("viewModels/TreatmentOnAnimalViewModel.php");

require_once("treatmentsOnAnimal.view.php");


class MedicamentDetailViewModel extends EditableDetailViewModelBase {

  public $Pk = "0";
  public $Name = "";
  public $Type = "";
  public $Price = "";
  public $Producer = "";
  public $Substance = "";

  public function __construct() {
    parent::__construct('MedicamentEntity');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->loadData();
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->PK;
    $this->Name       = $this->MainDBEntity->getColumnStringValue('med_name');
    $this->Type       = $this->MainDBEntity->getColumnStringValue('med_type_text');
    $this->Price      = $this->MainDBEntity->getColumnStringValue('med_price');
    $this->Producer   = $this->MainDBEntity->getColumnStringValue('med_producer');
    $this->Substance  = $this->MainDBEntity->getColumnStringValue('med_active_substance');
  }

  public function onSuccessPost() {
    SessionControl::navigate("medicamentDetail.view?pk=" . $this->MainDBEntity->PK);
  }
}

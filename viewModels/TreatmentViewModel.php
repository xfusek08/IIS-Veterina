<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/MedOnTreatBrowseEntity.php");

require_once("models/MedicamentOnTreatmentModel.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class TreatmentViewModel extends EditableDetailViewModelBase {
  public $Pk = 0;
  public $Caption = '';
  public $State = '';
  public $Prognosis = '';
  public $Price = '';
  public $Medicaments = array();  // array of MedicamentOnTreatmentModel

  public function __construct() {
    parent::__construct('TreatmentEntity');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() { }

  public function onSuccessPost() { }

  public function onSuccessDelete() { }

  public function loadData() {
    $this->Pk        = $this->MainDBEntity->Pk;
    $this->Caption   = $this->MainDBEntity->getColumnStringValue('tre_caption');
    $this->State     = $this->MainDBEntity->getColumnStringValue('tre_state_text');
    $this->Prognosis = $this->MainDBEntity->getColumnStringValue('tre_prognosis');
    $this->Price     = $this->MainDBEntity->getColumnStringValue('tre_price');

    $medOnTreBrowser = new DBEntityBrowser(
      "MedOnTreatBrowseEntity",
      "mot_trepk = ?",
      "med_name"
    );

    $medOnTreBrowser->addParams($this->Pk);
    $medOnTreBrowser->openBrowser();

    // medicaments
    while (($actMoT = $medOnTreBrowser->getNext()) != null) {
      $newModel = new MedicamentOnTreatmentModel();
      $newModel->MedPk     = $actMoT->getColumnStringValue('mot_medpk');
      $newModel->TrePk     = $actMoT->getColumnStringValue('mot_trepk');
      $newModel->Name      = $actMoT->getColumnStringValue('med_name');
      $newModel->UsageTime = $actMoT->getColumnStringValue('mot_usage_time');
      $newModel->Dosage    = $actMoT->getColumnStringValue('mot_dosage');
      $this->Medicaments[] = $newModel;
    }
  }
}
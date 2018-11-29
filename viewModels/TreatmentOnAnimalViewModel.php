<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/MedOnTreatBrowseEntity.php");
require_once("DBEntities/ExamOnTreatBrowseEntity.php");

require_once("models/MedicamentOnTreatmentModel.php");
require_once("models/ExamOnTreatmentModel.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class TreatmentOnAnimalViewModel extends EditableDetailViewModelBase {
  public $Caption = '';
  public $State = '';
  public $Prognosis = '';
  public $Price = '';
  public $Medicaments = array();  // array of MedicamentOnTreatmentModel
  public $Examinations = array(); // array of ExamOnTreatmentModel

  public function __construct() {
    parent::__construct('TreatmentEntity', 'treatmentsOnAnimal.view.php');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() { }

  public function onSuccessPost() { }

  public function loadData() {
    $this->Caption   = $this->MainDBEntity->getColumnStringValue('tre_caption');
    $this->State     = $this->MainDBEntity->getColumnStringValue('tre_state_text');
    $this->Prognosis = $this->MainDBEntity->getColumnStringValue('tre_prognosis');
    $this->Price     = $this->MainDBEntity->getColumnStringValue('tre_price');

    $medOnTreBrowser = new DBEntityBrowser(
      "MedOnTreatBrowseEntity",
      "treatment_pk = ?",
      "med_name"
    );

    $medOnTreBrowser->addParams($this->MainDBEntity->PK);
    $medOnTreBrowser->openBrowser();

    $examOnTreBrowser = new DBEntityBrowser(
      "ExamOnTreatBrowseEntity",
      "treatment_pk = ?",
      "exa_begin_date_time desc"
    );
    $examOnTreBrowser->addParams($this->MainDBEntity->PK);
    $examOnTreBrowser->openBrowser();

    // medicaments
    while (($actMoT = $medOnTreBrowser->getNext()) != null) {
      $newModel = new MedicamentOnTreatmentModel();
      $newModel->MedPk     = $actMoT->getColumnStringValue('medicament_pk');
      $newModel->TrePk     = $actMoT->getColumnStringValue('treatment_pk');
      $newModel->Name      = $actMoT->getColumnStringValue('med_name');
      $newModel->UsageTime = $actMoT->getColumnStringValue('mot_usage_time');
      $newModel->Dosage    = $actMoT->getColumnStringValue('mot_dosage');
      $this->Medicaments[] = $newModel;
    }

    // examinations
    while (($actEoT = $examOnTreBrowser->getNext()) != null) {
      $newModel = new ExamOnTreatmentModel();
      $beginDatetime = new DateTime();
      $beginDatetime->setTimestamp($actEoT->getColumnByName('exa_begin_date_time')->getValue());

      $newModel->ExaPk      = $actEoT->getColumnStringValue('examination_pk');
      $newModel->TrePk      = $actEoT->getColumnStringValue('treatment_pk');
      $newModel->Date       = $beginDatetime->format(DATE_FORMAT);
      $newModel->Type       = $actEoT->getColumnStringValue('exa_text');
      $newModel->Hour       = $beginDatetime->format("H:i");
      $newModel->Ocurred    = $actEoT->getColumnStringValue('exa_occurred');
      $newModel->Diagnosis  = $actEoT->getColumnStringValue('toe_ongoing_diagnosis');
      $newModel->Price      = $actEoT->getColumnStringValue('exa_price');
      $this->Examinations[] = $newModel;
    }
  }
}
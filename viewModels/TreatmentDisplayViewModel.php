<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/MedOnTreatBrowseEntity.php");
require_once("DBEntities/ExamOnTreatBrowseEntity.php");

require_once("models/MedicamentOnTreatmentModel.php");
require_once("models/ExamOnTreatmentModel.php");

require_once("viewModels/ViewModelBase.php");

class TreatmentDisplayViewModel extends ViewModelBase {
  public $Caption = '';
  public $State = '';
  public $Prognosis = '';
  public $Price = '';
  public $Medicaments = array();  // array of MedicamentOnTreatmentModel
  public $Examinations = array(); // array of ExamOnTreatmentModel

  public $IsEdit = false;

  private $TreatmentEnt = null;
  private $MedOnTreBrowser = null;
  private $ExamOnTreBrowser = null;

  public function __construct() {
    $this->Init();
  }

  public function init($pk = 0) {
    $this->TreatmentEnt = new TreatmentEntity($pk);
    $this->MedOnTreBrowser = new DBEntityBrowser(
      "MedOnTreatBrowseEntity",
      "treatment_pk = ?",
      "med_name"
    );

    $this->MedOnTreBrowser->addParams($pk);
    $this->MedOnTreBrowser->openBrowser();

    $this->ExamOnTreBrowser = new DBEntityBrowser(
      "ExamOnTreatBrowseEntity",
      "treatment_pk = ?",
      "exa_begin_date_time desc"
    );
    $this->ExamOnTreBrowser->addParams($pk);
    $this->ExamOnTreBrowser->openBrowser();
  }

  public function ProcessGet() {
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    else
      $this->IsEdit = true;
    $this->init($pk);
    $this->loadData();
  }

  public function loadData() {
    $this->Caption   = $this->TreatmentEnt->getColumnStringValue('tre_caption');
    $this->State     = $this->TreatmentEnt->getColumnStringValue('tre_state_text');
    $this->Prognosis = $this->TreatmentEnt->getColumnStringValue('tre_prognosis');
    $this->Price     = $this->TreatmentEnt->getColumnStringValue('tre_price');

    // medicaments
    while (($actMoT = $this->MedOnTreBrowser->getNext()) != null) {
      $newModel = new MedicamentOnTreatmentModel();
      $newModel->MedPk     = $actMoT->getColumnStringValue('medicament_pk');
      $newModel->TrePk     = $actMoT->getColumnStringValue('treatment_pk');
      $newModel->Name      = $actMoT->getColumnStringValue('med_name');
      $newModel->UsageTime = $actMoT->getColumnStringValue('mot_usage_time');
      $newModel->Dosage    = $actMoT->getColumnStringValue('mot_dosage');
      $this->Medicaments[] = $newModel;
    }

    // examinations
    while (($actEoT = $this->ExamOnTreBrowser->getNext()) != null) {
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
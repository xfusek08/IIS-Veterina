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
  public $Medicaments = array();  // array of MedicamentOnTreatmentModel
  public $Examinations = array(); // array of ExamOnTreatmentModel

  public $IsEdit = false;

  private $TreatmentEnt = null;
  private $MedicamentsBrowser = null;
  private $ExaminationsBrowser = null;

  public function __construct() {
    $this->Init();
  }

  public function init($pk = 0) {
    $this->Treatment = new TreatmentEntity($pk);
    $this->MedicamentsBrowser = new DBEntityBrowser(
      "MedOnTreatBrowseEntity",
      "treatment_pk = ?",
      "med_name"
    );

    $this->MedicamentsBrowser->addParams($pk);
    $this->MedicamentsBrowser->openBrowser();

    $this->ExaminationsBrowser = new DBEntityBrowser(
      "ExamOnTreatBrowseEntity",
      "treatment_pk = ?",
      "exa_begin_date_time desc"
    );
    $this->ExaminationsBrowser->addParams($pk);
    $this->ExaminationsBrowser->openBrowser();
  }

  public function loadFromGet() {
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    else
      $this->IsEdit = true;
    $this->init($pk);
  }

  public function loadData() {

  }
}
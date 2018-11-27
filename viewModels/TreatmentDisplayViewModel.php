<?php

require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/MedOnTreatBrowseEntity.php");
require_once("DBEntities/ExamOnTreatBrowseEntity.php");
require_once("lib/DBEntityBrowser.php");
require_once("viewModels/ViewModelBase.php");

class TreatmentDisplayViewModel extends ViewModelBase {
  public $IsEdit = false;
  public $Treatment = null;
  public $MedicamentsBrowser = null;
  public $ExaminationsBrowser = null;

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
    $this->MedicamentsBrowser->addParams($pk);
    $this->MedicamentsBrowser->openBrowser();
  }

  public function loadFromGet() {
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    else
      $this->IsEdit = true;
    $this->init($pk);
  }
}
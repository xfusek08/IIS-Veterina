<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/TreatmentOnExaminationEntity.php");

require_once("viewModels/TreatmentViewModel.php");

class TreatmentOnExaminationViewModel extends TreatmentViewModel {
  public $ExaminationPK;
  public $OngoingDiagnosis;

  public function __construct($examinationPK, $treatmentPK = 0) {
    parent::__construct();
    $this->ExaminationPK = $examinationPK;
    $this->initMainDbEntity($treatmentPK);
    $this->loadData();
  }

  public function initEdit() {
    // load species
  }

  public function onSuccessPost() {
    // navigate to detail
  }

  public function loadData() {
    parent::loadData();
    $browser = new DBEntityBrowser(
      "TreatmentOnExaminationEntity",
      "toe_exapk = ? and toe_trepk = ?"
    );
    $browser->addParams(array($this->ExaminationPK, $this->Pk));
    $browser->openBrowser();
    $this->OngoingDiagnosis = $browser->getNext()->getColumnStringValue('toe_ongoing_diagnosis');
  }
}
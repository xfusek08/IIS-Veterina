<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/ExamOnTreatBrowseEntity.php");

require_once("models/ExamOnTreatmentModel.php");

require_once("viewModels/TreatmentViewModel.php");

class TreatmentOnAnimalViewModel extends TreatmentViewModel {
  public $Examinations = array(); // array of ExamOnTreatmentModel

  public function __construct() {
    parent::__construct();
  }

  public function initEdit() { }      // not editable
  public function onSuccessPost() { } // not editable

  public function loadData() {
    parent::loadData();

    $examOnTreBrowser = new DBEntityBrowser(
      "ExamOnTreatBrowseEntity",
      "toe_trepk = ?",
      "exa_begin_date_time desc"
    );
    $examOnTreBrowser->addParams($this->MainDBEntity->Pk);
    $examOnTreBrowser->openBrowser();

    while (($actEoT = $examOnTreBrowser->getNext()) != null) {
      $newModel = new ExamOnTreatmentModel();
      $beginDatetime = $actEoT->getColumnByName('exa_begin_date_time')->getValue();

      $newModel->ExaPk      = $actEoT->getColumnStringValue('toe_exapk');
      $newModel->TrePk      = $actEoT->getColumnStringValue('toe_trepk');
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
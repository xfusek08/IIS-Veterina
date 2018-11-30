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
      "treatment_pk = ?",
      "exa_begin_date_time desc"
    );
    $examOnTreBrowser->addParams($this->MainDBEntity->PK);
    $examOnTreBrowser->openBrowser();

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
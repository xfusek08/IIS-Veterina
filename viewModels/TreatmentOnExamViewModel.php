<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/ExamOnTreatBrowseEntity.php");

require_once("models/ExamOnTreatmentModel.php");

require_once("viewModels/TreatmentViewModel.php");

class TreatmentOnExamViewModel extends TreatmentViewModel {
  public $Examinations = array(); // array of ExamOnTreatmentModel

  public function __construct() {
    parent::__construct();
  }

  public function initEdit() {
    // load species
  }

  public function onSuccessPost() {
    // navigate to detail
  }

  public function loadData() {
    parent::loadData();
  }
}
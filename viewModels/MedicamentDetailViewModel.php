<?php

require_once("DBEntities/MedicamentEntity.php");
require_once("DBEntities/TreatmentEntity.php");

require_once("viewModels/ViewModelBase.php");
require_once("viewModels/TreatmentDisplayViewModel.php");

require_once("TreatmentDisplay.view.php");


class MedicamentDetailViewModel extends ViewModelBase {

  public $Pk = "0";
  public $Name = "";
  public $Type = "";
  public $Price = "";
  public $Producer = "";
  public $Substance = "";

  public $Errors = array();

  public function ProcessGet() {
  }

  public function processPost() {
  }

  public function loadGetData() {
  }

  public function initView() {
  }

  public function LoadSpeciesHTML() {
    //species
  }

}
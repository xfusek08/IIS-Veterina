<?php

require_once("DBEntities/OwnerEntity.php");
require_once("DBEntities/TreatmentEntity.php");

require_once("viewModels/ViewModelBase.php");
require_once("viewModels/TreatmentDisplayViewModel.php");

require_once("TreatmentDisplay.view.php");


class OwnerDetailViewModel extends ViewModelBase {

  public $Pk = "0";
  public $Name = "";
  public $Firstname = "";
  public $Surname = "";
  public $Address = "";
  public $Sex = "";
  public $Number = "";

  public $Errors = array();

  public function ProcessGet() {
  }

  public function processPost() {

  }

  public function loadGetData() {
  }

  public function initView() {

  }

  public function LoadAnimalsHTML() {
    //AnimalDisplay.view.php
  }

}
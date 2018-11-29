<?php

require_once("DBEntities/OwnerEntity.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

require_once("TreatmentDisplay.view.php");

class OwnerDetailViewModel extends EditableDetailViewModelBase {
  public $Pk = 0;
  public $Name = "";
  public $Firstname = "";
  public $Surname = "";
  public $Address = "";
  public $Sex = "";
  public $Number = "";
  public $SexSelect = array();

  public function __construct() {
    parent::__construct('OwnerEntity');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->SexSelect = $this->LoadEditSelectData("select psex_shortcut, psex_text from Person_sex order by psex_order");
    $this->loadData();
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->PK;
    $this->Firstname  = $this->MainDBEntity->getColumnStringValue('own_name');
    $this->Surname    = $this->MainDBEntity->getColumnStringValue('own_surname');
    $this->Address    = $this->MainDBEntity->getColumnStringValue('own_address');
    $this->Sex        = $this->MainDBEntity->getColumnStringValue('own_sex');
    $this->Number     = $this->MainDBEntity->getColumnStringValue('own_mobile_number');
    $this->Name       = $this->Firstname . ' ' . $this->Surname;
  }

  public function onSuccessPost() {
    SessionControl::navigate("ownerDetail.view.php?pk=" . $this->MainDBEntity->PK);
  }

  // methods specific to Owner detail

  public function LoadAnimalsHTML() {
    //AnimalDisplay.view.php
  }

}
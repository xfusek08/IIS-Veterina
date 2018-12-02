<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/OwnerEntity.php");

require_once("models/AnimalBrowseModel.php");
require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class OwnerDetailViewModel extends EditableDetailViewModelBase {
  public $Pk = 0;
  public $Name = "";
  public $Firstname = "";
  public $Surname = "";
  public $Address = "";
  public $Sex = "";
  public $Number = "";
  public $Animals = array(); // array of AnimalBrowseModel

  public $SexSelect = array();

  public function __construct() {
    parent::__construct('OwnerEntity');
  }

  public function initView() {
    $this->loadData();
    $animalBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity", // selected entity class
      "own_pk = ?",      // where condition
      "exabegin desc",      // order by
      ""    // having condition
    );
    $animalBrowser->addParams($this->Pk);
    $animalBrowser->openBrowser();

    $this->Animals = Mapper::loadAnimalEntityBrowserToModelList($animalBrowser);
  }

  public function initEdit() {
    $this->SexSelect = $this->LoadEditSelectData("select psex_shortcut, psex_text from Person_sex order by psex_order");
    $this->loadData();
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->Pk;
    $this->Firstname  = $this->MainDBEntity->getColumnStringValue('own_name');
    $this->Surname    = $this->MainDBEntity->getColumnStringValue('own_surname');
    $this->Address    = $this->MainDBEntity->getColumnStringValue('own_address');
    $this->Sex        = $this->MainDBEntity->getColumnStringValue('own_sex_text');
    $this->Number     = $this->MainDBEntity->getColumnStringValue('own_mobile_number');
    $this->Name       = $this->Firstname . ' ' . $this->Surname;
  }

  public function onSuccessPost() {
    SessionControl::navigate("ownerDetail.view.php?pk=" . $this->MainDBEntity->Pk);
  }
}

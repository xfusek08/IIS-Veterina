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
  public $AnimalsPlanned = array(); // array of AnimalBrowseModel
  public $AnimalsNotPlanned = array(); // array of AnimalBrowseModel

  public $SexSelect = array();

  public function __construct() {
    parent::__construct('OwnerEntity');
  }

  public function initView() {
    $this->loadData();
    $aniPlanBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity",             // selected entity class
      "ani_state = 'A' and ani_owner",  // where condition
      "exabegin",                       // order by
      "exabegin > now()"                // having condition
    );
    $aniNPlanBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity",             // selected entity class
      "ani_state = 'A' and ani_owner",  // where condition
      "exabegin desc",                  // order by
      "exabegin < now()"                // having condition
    );
    $aniPlanBrowser->openBrowser();
    $aniNPlanBrowser->openBrowser();

    $this->AnimalsPlanned    = Mapper::loadAnimalEntityBrowserToModelList($aniPlanBrowser);
    $this->AnimalsNotPlanned = Mapper::loadAnimalEntityBrowserToModelList($aniNPlanBrowser);
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

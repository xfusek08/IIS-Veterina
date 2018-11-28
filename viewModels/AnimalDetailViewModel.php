<?php

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/TreatmentEntity.php");

require_once("viewModels/ViewModelBase.php");
require_once("viewModels/TreatmentDisplayViewModel.php");

require_once("TreatmentDisplay.view.php");


class AnimalDetailViewModel extends ViewModelBase {
  public $AnimalName = '';
  public $OwnerName = '';
  public $Species = '';
  public $Race = '';
  public $Sex = '';
  public $Weight = '';
  public $State = '';
  public $Birthday = '';
  public $Age = '';
  public $AnimalPk = 0;
  public $OwnerPk = 0;

  public $SexSelect = array();
  public $SpeciesSelect = array();
  public $StateSelect = array();

  public $Errors = array();

  public $IsEdit = false;

  private $AnimalEnt = null;

  public function __construct() {
    $this->AnimalEnt = new AnimalEntity();
  }

  public function ProcessGet() {
    $this->loadGetData();
    if ($this->IsEdit)
      $this->initEdit();
    else
      $this->initView();
    $this->loadData();
  }

  public function processPost() {
    $this->loadGetData();
    $this->AnimalEnt->loadFromPostData();
    if (!$this->AnimalEnt->isDataValid()) {
      $this->Errors = $this->AnimalEnt->GetInvalidData();
      echo '<pre>', var_dump($this->Errors) , '</pre>';
      $this->initEdit();
    }
    else {
      if (!$this->AnimalEnt->saveToDB()) {
        die('save failed');
      }
      die('save sucessfull');

      // redirect or error notification
    }
  }

  public function loadGetData() {
    $this->OwnerPk = 0;
    $this->AnimalPk = 0;
    if (isset($_GET['pk']))
      $this->AnimalPk = intval($_GET['pk']);
    if (isset($_GET['onwnerpk']))
      $this->OwnerPk = intval($_GET['onwnerpk']);
    $this->IsEdit = isset($_GET['edit']) || $this->AnimalPk == 0;
    $this->AnimalEnt = new AnimalEntity($this->AnimalPk);
  }

  public function initView() {

  }

  public function initEdit() {
    if ($this->AnimalPk == 0 && $this->OwnerPk < 1)
      die("Can't create new animal without knowing owner pk.");

    $this->SexSelect = $this->LoadEditSelectData("select asex_shortcut, asex_description from Animal_sex order by asex_description");
    $this->SpeciesSelect = $this->LoadEditSelectData("select spe_pk, spe_name from Animal_species order by spe_name");
    $this->StateSelect = $this->LoadEditSelectData("select ast_shortcut , ast_text from Animal_state order by ast_text");
    $this->loadData();
  }

  public function loadData() {
    $this->AnimalName = $this->AnimalEnt->getColumnStringValue('ani_name');
    $this->OwnerName  = $this->AnimalEnt->getColumnStringValue('owner_name');
    $this->Species    = $this->AnimalEnt->getColumnStringValue('ani_species_text');
    $this->Sex        = $this->AnimalEnt->getColumnStringValue('ani_sex_text');
    $this->Weight     = $this->AnimalEnt->getColumnStringValue('ani_weight');
    $this->State      = $this->AnimalEnt->getColumnStringValue('ani_state_text');
    $this->Birthday   = $this->AnimalEnt->getColumnStringValue('ani_birthday');
    $this->Race       = $this->AnimalEnt->getColumnStringValue('ani_race');
    $this->Age        = $this->calculateAgeOfAnimal();
  }

  public function LoadTreatmentsHTML() {
    $browser = new DBEntityBrowser(
      "TreatmentEntity",
      "tre_animal = ?",
      "tre_priority"
    );
    $browser->addParams($this->AnimalPk);
    $browser->openBrowser();

    if ($browser->Loaded == 0) {
      echo "Žádné léčby";
    } else {
      while(($actTreat = $browser->getNext()) != null) {
        $vm = new TreatmentDisplayViewModel();
        $vm->init($actTreat->getColumnByName('tre_pk')->getValue());
        $vm->loadData();
        BuildTreatmentViewDiv($vm);
      }
    }
  }

  private function calculateAgeOfAnimal() {
    $birthday = $this->AnimalEnt->getColumnByName('ani_birthday')->getValue();
    $date = new DateTime();
    $date->setTimestamp($birthday);
    $now = new DateTime();
    return $now->diff($date)->y;
  }
}

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
  public $Sex = '';
  public $Weight = '';
  public $State = '';
  public $Birthday = '';
  public $Age = '';

  public $IsEdit = false;

  private $AnimalEnt = null;
  private $TreatmentsBrowser = null;
  private $ExaminationBrowser = null;

  public function __construct() {
    $this->AnimalEnt = new AnimalEntity();
  }

  public function init($pk) {
    $this->AnimalEnt = new AnimalEntity($pk);
    $this->IsEdit = $pk == 0;

    $this->TreatmentsBrowser = new DBEntityBrowser(
      "TreatmentEntity",
      "tre_animal = ?",
      "tre_priority"
    );
    $this->TreatmentsBrowser->addParams($pk);
    $this->TreatmentsBrowser->openBrowser();
  }

  public function loadFromGet() {
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    $this->init($pk);
    $this->loadData();
  }

  public function processAjax() {}

  public function processPost() {}

  public function loadData() {
    $this->AnimalName = $this->AnimalEnt->getColumnStringValue('ani_name');
    $this->OwnerName  = $this->AnimalEnt->getColumnStringValue('owner_name');
    $this->Species    = $this->AnimalEnt->getColumnStringValue('ani_species_text');
    $this->Sex        = $this->AnimalEnt->getColumnStringValue('ani_sex_text');
    $this->Weight     = $this->AnimalEnt->getColumnStringValue('ani_weight');
    $this->State      = $this->AnimalEnt->getColumnStringValue('ani_state_text');
    $this->Birthday   = $this->AnimalEnt->getColumnStringValue('ani_birthday');
    $this->Age        = $this->calculateAgeOfAnimal();
  }

  public function LoadTreatmentsHTML() {
    if ($this->TreatmentsBrowser->Loaded == 0) {
      echo "Žádné léčby";
    } else {
      while(($actTreat = $this->TreatmentsBrowser->getNext()) != null) {
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

<?php

require_once("lib/SessionControl.php");
require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/ExaminationEntity.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");
require_once("viewModels/TreatmentOnAnimalViewModel.php");
require_once("viewModels/ExaminationsOnAnimalViewModel.php");

require_once("treatmentsOnAnimal.view.php");
require_once("examinationsOnAnimal.view.php");

class AnimalDetailViewModel extends EditableDetailViewModelBase {
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

  public function __construct() {
    parent::__construct('AnimalEntity', 'animalDetail.view.php');
  }

  public function loadGetData() {
    parent::loadGetData();
    if (isset($_GET['onwnerpk']))
      $this->OwnerPk = intval($_GET['onwnerpk']);
    $this->AnimalPk = $this->MainDBEntity->PK;
  }

  public function initView() {
    $this->loadData();
  }

  public function onSuccessPost() {
    SessionControl::navigate("animalDetail.view.php?pk=" . $this->MainDBEntity->PK);
  }

  public function initEdit() {
    if ($this->AnimalPk == 0 && $this->OwnerPk < 1)
      die("Can't create new animal without knowing owner pk.");

    $this->SexSelect      = $this->LoadEditSelectData("select asex_shortcut, asex_description from Animal_sex order by asex_description");
    $this->SpeciesSelect  = $this->LoadEditSelectData("select spe_pk, spe_name from Animal_species order by spe_name");
    $this->StateSelect    = $this->LoadEditSelectData("select ast_shortcut , ast_text from Animal_state order by ast_text");
    $this->loadData();
  }

  public function loadData() {
    $this->AnimalName = $this->MainDBEntity->getColumnStringValue('ani_name');
    $this->OwnerName  = $this->MainDBEntity->getColumnStringValue('owner_name');
    $this->Species    = $this->MainDBEntity->getColumnStringValue('ani_species_text');
    $this->Sex        = $this->MainDBEntity->getColumnStringValue('ani_sex_text');
    $this->Weight     = $this->MainDBEntity->getColumnStringValue('ani_weight');
    $this->State      = $this->MainDBEntity->getColumnStringValue('ani_state_text');
    $this->Birthday   = $this->MainDBEntity->getColumnStringValue('ani_birthday');
    $this->Race       = $this->MainDBEntity->getColumnStringValue('ani_race');
    $this->Age        = $this->calculateAgeOfAnimal();
  }

  // methods specific to Animal detail

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
      while(($actEnt = $browser->getNext()) != null) {
        $vm = new TreatmentOnAnimalViewModel();
        $vm->initMainDbEntity($actEnt->getColumnByName('tre_pk')->getValue());
        $vm->loadData();
        BuildTreatmentsOnAnimalView($vm);
      }
    }
  }

  public function LoadExaminationHTML() {
    $browser = new DBEntityBrowser(
      "ExaminationEntity",
      "exa_animal = ?",
      "exa_begin_date_time"
    );
    $browser->addParams($this->AnimalPk);
    $browser->openBrowser();

    if ($browser->Loaded == 0) {
      echo "Žádná vyšetření";
    } else {
      while(($actEnt = $browser->getNext()) != null) {
        $vm = new ExaminationsOnAnimalViewModel();
        $vm->initMainDbEntity($actEnt->getColumnByName('exa_pk')->getValue());
        $vm->loadData();
        BuildExaminationsOnAnimalView($vm);
      }
    }
  }

  private function calculateAgeOfAnimal() {
    $birthday = $this->MainDBEntity->getColumnByName('ani_birthday')->getValue();
    $date = new DateTime();
    $date->setTimestamp($birthday);
    $now = new DateTime();
    return $now->diff($date)->y;
  }
}

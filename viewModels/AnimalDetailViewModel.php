<?php

require_once("lib/SessionControl.php");
require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/OwnerEntity.php");
require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/ExaminationEntity.php");

require_once("models/ExaminationModel.php");
require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");
require_once("viewModels/TreatmentOnAnimalViewModel.php");

require_once("treatmentsOnAnimal.view.php");

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
  public $Examinations = array(); // array of ExaminationModel

  public $SexSelect = array();
  public $SpeciesSelect = array();
  public $StateSelect = array();

  public function __construct() {
    parent::__construct('AnimalEntity', 'animalDetail.view.php');
  }

  public function loadGetData() {
    parent::loadGetData();
    $this->AnimalPk = $this->MainDBEntity->Pk;
    if (isset($_GET['ownerpk'])) {
      $this->OwnerPk = intval($_GET['ownerpk']);
      if ($this->AnimalPk == 0)
        $this->MainDBEntity->getColumnByName('ani_owner')->setValue($this->OwnerPk);
    }
  }

  public function initView() {
    $this->loadData();

    $examinationBrowser = new DBEntityBrowser(
      "ExaminationEntity",
      "exa_animal = ?",
      "exa_begin_date_time desc"
    );
    $examinationBrowser->addParams($this->AnimalPk);
    $examinationBrowser->openBrowser();

    while (($actExamEntity = $examinationBrowser->getNext()) != null) {
      $this->Examinations[] = Mapper::entityToExaminationModel($actExamEntity);
    }
  }

  public function onSuccessPost() {
    SessionControl::navigate("animalDetail.view.php?pk=" . $this->MainDBEntity->Pk);
  }

  public function onSuccessDelete() {
    echo "onSuccessDelete";
    SessionControl::navigate("ownerDetail.view.php?pk=" . $this->OwnerPk);
  }

  public function initEdit() {
    if ($this->AnimalPk == 0 && $this->OwnerPk < 1)
      die("Can't create new animal without knowing owner pk.");

    $this->SexSelect      = $this->LoadEditSelectData("select asex_shortcut, asex_description from Animal_sex order by asex_description");
    $this->SpeciesSelect  = $this->LoadEditSelectData("select spe_pk, spe_name from Animal_species order by spe_name");
    $this->StateSelect    = $this->LoadEditSelectData("select ast_shortcut , ast_text from Animal_state order by ast_text");

    $this->loadData();

    $ownEntity = new OwnerEntity($this->OwnerPk);
    $this->OwnerName =
      $ownEntity->getColumnStringValue('own_surname') . ' ' .
      $ownEntity->getColumnStringValue('own_name');
  }

  public function loadData() {
    $this->OwnerPk    = $this->MainDBEntity->getColumnByName('ani_owner')->getValue();
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
    $TreatmentBrowser = new DBEntityBrowser(
      "TreatmentEntity",
      "tre_animal = ?",
      "tre_priority"
    );
    $TreatmentBrowser->addParams($this->AnimalPk);
    $TreatmentBrowser->openBrowser();

    if ($TreatmentBrowser->Loaded == 0) {
      echo "Žádné léčby";
    } else {
      while(($actTre = $TreatmentBrowser->getNext()) != null) {
        $vm = new TreatmentOnAnimalViewModel();
        $vm->initMainDbEntity($actTre->getColumnByName('tre_pk')->getValue());
        $vm->loadData();
        BuildTreatmentsOnAnimalView($vm);
      }
    }
  }

  private function calculateAgeOfAnimal() {
    $birthday = $this->MainDBEntity->getColumnByName('ani_birthday')->getValue();
    if ($birthday == null)
      return 0;
    $now = new DateTime();
    return $now->diff($birthday)->y;
  }
}

<?php

require_once("lib/SessionControl.php");
require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/TreatmentEntity.php");
require_once("DBEntities/ExaminationEntity.php");

require_once("models/ExaminationModel.php");

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
    if (isset($_GET['onwnerpk']))
      $this->OwnerPk = intval($_GET['onwnerpk']);
    $this->AnimalPk = $this->MainDBEntity->PK;
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

    while (($actExam = $examinationBrowser->getNext()) != null) {
      $dateOcured = new DateTime();
      $dateOcured->setTimestamp($actExam->getColumnByName('exa_begin_date_time')->getValue());

      $examModel = new ExaminationModel();
      $examModel->PK            = $actExam->getColumnByName('exa_pk')->getValue();
      $examModel->AnimalPK      = $actExam->getColumnByName('exa_animal')->getValue();
      $examModel->EmployeePK    = $actExam->getColumnByName('exa_employee')->getValue();
      $examModel->EmployeeName  = $actExam->getColumnStringValue('employee_name');
      $examModel->Date          = $dateOcured->format(DATE_FORMAT);
      $examModel->Hour          = $dateOcured->format("H:i");
      $examModel->Type          = $actExam->getColumnStringValue('exa_type_text');
      $examModel->Duration      = $actExam->getColumnStringValue('exa_duration_minutes');
      $examModel->Price         = $actExam->getColumnStringValue('exa_price');
      $examModel->Report        = $actExam->getColumnStringValue('exa_final_report');
      $examModel->Occured       = $actExam->getColumnStringValue('exa_occurred');
      $this->Examinations[] = $examModel;
    }
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
    $date = new DateTime();
    $date->setTimestamp($birthday);
    $now = new DateTime();
    return $now->diff($date)->y;
  }
}

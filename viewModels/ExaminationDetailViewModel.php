<?php

require_once("lib/DBEntityBrowser.php");
require_once("lib/EntityListOnEntityCollection.php");

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/EmployeeEntity.php");
require_once("DBEntities/ExaminationEntity.php");
require_once("DBEntities/MedicamentEntity.php");

require_once("models/ExaminationModel.php");
require_once("models/MedicamentModel.php");

require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

require_once("treatmentsOnExamination.view.php");

class ExaminationDetailViewModel extends EditableDetailViewModelBase {
  private $_medOnExamCollection = null; // instance of EntityListOnEntityCollection

  public $Examination = null; // instance of ExaminationModel
  public $Animal = null; // instance of AnimalModel
  public $Employee = null; // instance of EmployeeModel

  public $Medicaments = null; // instance of MedicamentModel

  public $ExaminationTypeSelect = array();
  public $MedicamentSelect = array();

  public function __construct() {
    parent::__construct('ExaminationEntity');
    $this->Examination = new ExaminationModel();
    $this->Animal = new AnimalModel();
    $this->Employee = new EmployeeModel();

    $this->_medOnExamCollection = new EntityListOnEntityCollection(
      "MedicamentModel",
      function($entity) { return Mapper::entityToMedicamentModel($entity); }
    );
  }

  public function loadGetData() {
    parent::loadGetData();
    $this->Animal->Pk = getIntFromGet('animalpk');
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->loadData();
    $this->ExaminationTypeSelect = $this->LoadEditSelectData("select exa_shortcut, exa_text from Examination_type order by exa_text");
    $this->MedicamentSelect = $this->LoadEditSelectData("select med_pk, concat(med_name, ', ', med_producer, ', ', medt_text) from Medicament join Medicament_type on medt_pk = med_type order by med_name");
  }

  public function loadData() {
    $this->Examination = Mapper::entityToExaminationModel($this->MainDBEntity);
    $this->Animal = Mapper::entityToAnimalModel(new AnimalEntity($this->Examination->AnimalPK));
    $this->Employee = Mapper::entityToEmployeeModel(new EmployeeEntity($this->Examination->EmployeePK));

    $medOnExaBrowser = new DBEntityBrowser(
      "MedicamentEntity",
      "exists (select * from Medicament_on_Examination where moe_exapk = ?)",
      "med_name"
    );
    $medOnExaBrowser->addParams($this->Examination->Pk);
    $medOnExaBrowser->openBrowser();

    while (($medEnt = $medOnExaBrowser->getNext()) != null) {
      $medEnt->Pk = $medEnt->getColumnByName('med_pk')->getValue();
      $this->_medOnExamCollection->addEntity($medEnt);
    }

    $this->Medicaments = $this->_medOnExamCollection->getModelList();
  }

  public function onSuccessPost() {
    SessionControl::navigate("examinationDetail.view.php?pk=" . $this->MainDBEntity->Pk);
  }

  public function LoadTreatmentsHTML() {
    $treatmentBrowser = new DBEntityBrowser(
      "TreatmentOnExaminationEntity",
      "toe_exapk = ?"
    );
    $treatmentBrowser->addParams($this->Examination->Pk);
    $treatmentBrowser->openBrowser();

    if ($treatmentBrowser->Loaded == 0) {
      echo "Žádné léčby";
    } else {
      while(($actTre = $treatmentBrowser->getNext()) != null) {
        $vm = new TreatmentOnExaminationViewModel(
          $this->Examination->Pk,
          $actTre->getColumnByName('toe_trepk')->getValue()
        );
        BuildTreatmentsOnExaminationView($vm);
      }
    }
  }
  public function onSuccessDelete() {  }
}

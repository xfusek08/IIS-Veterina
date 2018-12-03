<?php

require_once("lib/DBEntityBrowser.php");
require_once("lib/EntityListOnEntityCollection.php");

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
  public $Medicaments = null; // instance of MedicamentModel

  public function __construct() {
    parent::__construct('ExaminationEntity');
    $this->Examination = new ExaminationModel();

    $this->_medOnExamCollection = new EntityListOnEntityCollection(
      "MedicamentModel",
      function($entity) { return Mapper::entityToMedicamentModel($entity); }
    );
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->loadData();
  }

  public function loadData() {
    $this->Examination = Mapper::entityToExaminationModel($this->MainDBEntity);

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

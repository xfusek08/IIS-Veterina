<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/MedicamentEntity.php");
require_once("DBEntities/MedicamentForSpeciesEntity.php");

require_once("models/MedicamentForSpeciesModel.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class MedicamentDetailViewModel extends EditableDetailViewModelBase {

  public $Pk = 0;
  public $Name = "";
  public $Type = "";
  public $Price = "";
  public $Producer = "";
  public $Substance = "";
  public $MedForSpec = array();

  public $TypeSelect = array();

  public function __construct() {
    parent::__construct('MedicamentEntity');
  }

  public function initView() {
    $this->loadData();

    $mesOnSpeciesBrwoser = new DBEntityBrowser(
      "MedicamentForSpeciesEntity",
      "mfs_medpk = ?",
      "spe_name"
    );
    $mesOnSpeciesBrwoser->addParams($this->Pk);
    $mesOnSpeciesBrwoser->openBrowser();

    while (($actEntity = $mesOnSpeciesBrwoser->getNext()) != null) {
      $mesOnSpecModel = new MedicamentForSpeciesModel();
      $mesOnSpecModel->Pk                = $actEntity->getColumnByName('mfs_pk')->getValue();;
      $mesOnSpecModel->MedPk             = $actEntity->getColumnByName('mfs_medpk')->getValue();;
      $mesOnSpecModel->SpeciesPK         = $actEntity->getColumnByName('mfs_spepk')->getValue();;
      $mesOnSpecModel->Species           = $actEntity->getColumnStringValue('spe_name');
      $mesOnSpecModel->RecommendedDose   = $actEntity->getColumnStringValue('mfs_recommended_dosis');
      $mesOnSpecModel->EffectiveAgainst  = $actEntity->getColumnStringValue('mfs_effective_against');
      $this->MedForSpec[] = $mesOnSpecModel;
    }
  }

  public function initEdit() {
    $this->loadData();

    $this->TypeSelect = $this->LoadEditSelectData("select medt_pk, medt_text from Medicament_type order by medt_text");
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->PK;
    $this->Name       = $this->MainDBEntity->getColumnStringValue('med_name');
    $this->Type       = $this->MainDBEntity->getColumnStringValue('med_type_text');
    $this->Price      = $this->MainDBEntity->getColumnStringValue('med_price');
    $this->Producer   = $this->MainDBEntity->getColumnStringValue('med_producer');
    $this->Substance  = $this->MainDBEntity->getColumnStringValue('med_active_substance');
  }

  public function onSuccessPost() {
    SessionControl::navigate("medicamentDetail.view?pk=" . $this->MainDBEntity->PK);
  }
}

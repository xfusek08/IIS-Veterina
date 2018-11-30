<?php

require_once("lib/Logs.php");
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
  public $SpeciesSelect = array();

  private $MesOnSpeciesBrwoser = null; // instance of DBEntityBrowser

  public function __construct() {
    parent::__construct('MedicamentEntity');
  }

  public function loadGetData() {
    parent::loadGetData();
    $this->MesOnSpeciesBrwoser = new DBEntityBrowser(
      "MedicamentForSpeciesEntity",
      "mfs_medpk = ?",
      "spe_name"
    );
    $this->MesOnSpeciesBrwoser->addParams($this->Pk);
    $this->MesOnSpeciesBrwoser->openBrowser();
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {
    $this->loadData();

    $this->TypeSelect = $this->LoadEditSelectData("select medt_pk, medt_text from Medicament_type order by medt_text");
    $this->SpeciesSelect = $this->LoadEditSelectData('select spe_pk, spe_name from Animal_species order by spe_name');
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->PK;
    $this->Name       = $this->MainDBEntity->getColumnStringValue('med_name');
    $this->Type       = $this->MainDBEntity->getColumnStringValue('med_type_text');
    $this->Price      = $this->MainDBEntity->getColumnStringValue('med_price');
    $this->Producer   = $this->MainDBEntity->getColumnStringValue('med_producer');
    $this->Substance  = $this->MainDBEntity->getColumnStringValue('med_active_substance');

    $this->initMedOnSpeBrowser();
    while (($actEntity = $this->MesOnSpeciesBrwoser->getNext()) != null) {
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

  public function processPost() {
    $this->loadGetData();
    $this->MainDBEntity->loadFromPostData();
    $isAllSuccess = $this->MainDBEntity->isDataValid();
    $this->Errors = array_merge($this->Errors, $this->MainDBEntity->GetInvalidData($prefix));

    $toDeletePKs = array();
    $toSaveEntities = array();

    $cnt = intval($_POST['medCount']);
    while (($actEntity = $this->MesOnSpeciesBrwoser->getNext()) != null) {
      $toDeletePKs = $actEntity->PK;
    }

    $index = 0;
    while ($index < $cnt) {
      $prefix = '';
      if ($index == 0)
        $prefix = $index . '_';

      $actEntity = new MedicamentForSpeciesModel(intval($_POST[$prefix . 'mfs_pk']));

      $indexOfPK = array_search($actEntity->Pk, $toDeletePKs);
      if ($indexOfPK !== false)
        unset($toDeletePKs[$indexOfPK]);

      $actEntity->loadFromPostData($prefix);
      $isAllSuccess = $isAllSuccess && $actEntity->isDataValid();
      $this->Errors = array_merge($this->Errors, $actEntity->GetInvalidData($prefix));
      $toSaveEntities[] = $actEntity;
      $index = $index - 1;
    }

    if (!$isAllSuccess) {
      $this->Message = STR_MSG_FORM_INVALID_DATA;
      $this->initEdit();
    } else {
      $this->tryToSaveToDB($toSaveEntities, $toDeletePKs);
    }
  }

  public function onSuccessPost() {
    SessionControl::navigate("medicamentDetail.view?pk=" . $this->MainDBEntity->PK);
  }

  public function tryToSaveToDB($toSaveEntities, $toDeletePKs) {
    try {
      MyDatabase::$PDO->beginTransaction();
      $success = true;

      echo '<pre>', var_dumb($toSaveEntities), '</pre>';

      if ($success) {
        MyDatabase::$PDO->commit();
      } else {
        Logging::WriteLog(LogType::Anouncement, "RollBack");
        MyDatabase::$PDO->rollBack();
      }
    } catch (PDOException $e) {
      Log::WriteLog(LogType::Error, $e->getMessage());
      Log::WriteLog(LogType::Anouncement, "RollBack");
      MyDatabase::$PDO->rollBack();
      $succes = false;
    }
    return $succes;
  }
}

<?php

require_once("lib/Logs.php");
require_once("lib/DBEntityBrowser.php");
require_once("lib/EntityListOnEntityCollection.php");

require_once("DBEntities/MedicamentEntity.php");
require_once("DBEntities/MedicamentForSpeciesEntity.php");

require_once("models/MedicamentForSpeciesModel.php");

require_once("logic/Mapper.php");

require_once("viewModels/base/EditableDetailViewModelBase.php");

class MedicamentDetailViewModel extends EditableDetailViewModelBase {
  private $_medsOnSpeciesCollection = null; // instance of EntityListOnEntityCollection

  public $Pk = 0;
  public $Name = "";
  public $Type = "";
  public $Price = "";
  public $Producer = "";
  public $Substance = "";
  public $MedForSpec = array();

  public $TypeSelect = array();
  public $SpeciesSelect = array();

  public function __construct() {
    parent::__construct('MedicamentEntity');
    $this->_medsOnSpeciesCollection = new EntityListOnEntityCollection(
      "MedicamentForSpeciesEntity",
      function($entity) { return Mapper::entityToMedicamentForSpeciesModel($entity); }
    );
  }

  public function loadGetData() {
    parent::loadGetData();
    $medsOnSpeciesBrowser = new DBEntityBrowser(
      "MedicamentForSpeciesEntity",
      "mfs_medpk = ?",
      "spe_name"
    );
    $medsOnSpeciesBrowser->addParams($this->MainDBEntity->Pk);
    $medsOnSpeciesBrowser->openBrowser();
    $this->_medsOnSpeciesCollection->clearAll();
    while (($actEntity = $medsOnSpeciesBrowser->getNext()) != null) {
      $actEntity->Pk = $actEntity->getColumnByName('mfs_pk')->getValue();
      $this->_medsOnSpeciesCollection->addEntity($actEntity);
    }
  }

  public function initView() {
    $this->loadData();
  }

  public function initEdit() {

    $this->TypeSelect = $this->LoadEditSelectData("select medt_pk, medt_text from Medicament_type order by medt_text");
    $this->SpeciesSelect = $this->LoadEditSelectData('select spe_pk, spe_name from Animal_species order by spe_name');

    if ($this->_medsOnSpeciesCollection->countEntities() == 0)
      $this->_medsOnSpeciesCollection->addEntityByPK(0);

    $this->loadData();
  }

  public function onSuccessPost() {
    SessionControl::navigate("medicamentDetail.view?pk=" . $this->MainDBEntity->Pk);
  }

  public function onSuccessDelete() {
    SessionControl::navigate("medicamentBrowse.view.php");
  }

  public function loadData() {
    $this->Pk         = $this->MainDBEntity->Pk;
    $this->Name       = $this->MainDBEntity->getColumnStringValue('med_name');
    $this->Type       = $this->MainDBEntity->getColumnStringValue('med_type_text');
    $this->Price      = $this->MainDBEntity->getColumnStringValue('med_price');
    $this->Producer   = $this->MainDBEntity->getColumnStringValue('med_producer');
    $this->Substance  = $this->MainDBEntity->getColumnStringValue('med_active_substance');

    $this->MedForSpec = $this->_medsOnSpeciesCollection->getModelList();
  }

  public function processPost() {
    $this->loadGetData();
    $this->MainDBEntity->loadFromPostData();
    $isAllSuccess = $this->MainDBEntity->isDataValid();
    $this->Errors = array_merge($this->Errors, $this->MainDBEntity->GetInvalidData());
    $isAllSuccess = $this->_medsOnSpeciesCollection->loadFromPostData(getIntFromPost('medCount')) && $isAllSuccess;
    $this->Errors = array_merge($this->Errors, $this->_medsOnSpeciesCollection->getErrorLoadList());

    if (!$isAllSuccess) {
      $this->Message = STR_MSG_FORM_INVALID_DATA;
      $this->initEdit();
    } else {
      if ($this->tryToSaveToDB())
        $this->onSuccessPost();
      else {
        $this->Message = STR_DATABASE_ERROR;
      }
    }
  }

  public function tryToSaveToDB() {
    $success = true;
    try {
      MyDatabase::$PDO->beginTransaction();

      if (!$this->MainDBEntity->saveToDB(true))
        throw new Exception('Failed to save main medicament entity.');

      $this->_medsOnSpeciesCollection->saveToDB(true);

      MyDatabase::$PDO->commit();
    } catch (Exception $e) {
      Log::WriteLog(LogType::Error, $e->getMessage());
      Log::WriteLog(LogType::Announcement, "RollBack");
      MyDatabase::$PDO->rollBack();
      $success = false;
    }
    return $success;
  }
}

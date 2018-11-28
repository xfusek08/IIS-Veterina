<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/AnimalBrowseEntity.php");
require_once("models/AnimalBrowseModel.php");

require_once("viewModels/ViewModelBase.php");

class AnimalBrowseViewModel extends ViewModelBase {
  public $AnimalsPlanned = array(); // array of AnimalBrowseModel
  public $AnimalsNotPlanned = array(); // array of AnimalBrowseModel
  public $SearchString = '';

  private $AniPlanBrowser   = null;
  private $AniNPlanBrowser  = null;

  public function init() {
    $this->Animals = array();
    $this->AniPlanBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity", // selected entity class
      "ani_state = 'A'",    // where condition
      "exabegin",           // order by
      "exabegin > now()"    // having condition
    );
    $this->AniNPlanBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity", // selected entity class
      "ani_state = 'A'",    // where condition
      "exabegin desc",      // order by
      "exabegin < now()"    // having condition
    );
    $this->AniPlanBrowser->openBrowser();
    $this->AniNPlanBrowser->openBrowser();
  }

  public function ProcessGet() {
    if (isset($_GET['search']))
      $this->SearchString = $_GET['search'];
    $this->init();
    $this->loadData();
  }

  public function processAjax() {}

  public function processPost() {}

  public function loadData() {
    // TODO: filtrace na stav ??
    while (($aniBrEnt = $this->AniPlanBrowser->getNext()) != null) {
      $model = $this->aniBrEntToBrMod($aniBrEnt);
      if ($this->SearchString == '' || strpos(strtolower($model->AnimalName . $model->OwnerName . $model->LatestExamination), strtolower($this->SearchString)) !== false)
        $this->AnimalsPlanned[] = $model;
    }

    // TODO: filtrace na stav ??
    while (($aniBrEnt = $this->AniNPlanBrowser->getNext()) != null) {
      $model = $this->aniBrEntToBrMod($aniBrEnt);
      if ($this->SearchString == '' || strpos(strtolower($model->AnimalName . $model->OwnerName . $model->LatestExamination), strtolower($this->SearchString)) !== false)
        $this->AnimalsNotPlanned[] = $model;
    }
  }

  private function aniBrEntToBrMod($entity) {
    $animalBrowseModel = new AnimalBrowseModel();
    $animalBrowseModel->Pk                 = $entity->getColumnStringValue('ani_pk');
    $animalBrowseModel->AnimalName         = $entity->getColumnStringValue('ani_name');
    $animalBrowseModel->OwnerName          = $entity->getColumnStringValue('ownername');
    $animalBrowseModel->Species            = $entity->getColumnStringValue('spe_name');
    $animalBrowseModel->Sex                = $entity->getColumnStringValue('asex_description');
    $animalBrowseModel->State              = $entity->getColumnStringValue('ast_text');
    $animalBrowseModel->TreatmentNumber    = $entity->getColumnStringValue('treatmentcnt');
    $animalBrowseModel->LatestExamination  = $entity->getColumnStringValue('exabegin');
    return $animalBrowseModel;
  }
}

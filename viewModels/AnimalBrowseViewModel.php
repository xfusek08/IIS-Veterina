<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/AnimalBrowseEntity.php");

require_once("models/AnimalBrowseModel.php");

require_once("logic/Mapper.php");

require_once("viewModels/base/ViewModelBase.php");

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

  public function loadData() {
    $this->AnimalsPlanned    = Mapper::loadAnimalEntityBrowserToModelList($this->AniPlanBrowser, $this->SearchString);
    $this->AnimalsNotPlanned = Mapper::loadAnimalEntityBrowserToModelList($this->AniNPlanBrowser, $this->SearchString);
  }
}

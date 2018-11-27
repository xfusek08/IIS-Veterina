<?php

require_once("DBEntities/AnimalEntity.php");
require_once("DBEntities/TreatmentEntity.php");
require_once("viewModels/ViewModelBase.php");

class AnimalDetailViewModel extends ViewModelBase {
  public $IsEdit = false;
  public $Animal = null;
  public $TreatmentsBrowser = null;
  public $ExaminationBrowser = null;

  public function __construct() {
    $this->Animal = new AnimalEntity();
  }

  public function loadFromGet() {
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    $this->Animal = new AnimalEntity($pk);
    $this->IsEdit = $pk == 0;
  }

  public function processAjax() {}

  public function processPost() {
    $this->Animal->loadFromPostData();
  }
}

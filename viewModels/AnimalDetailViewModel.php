<?php

require_once("DBEntities/AnimalEntity.php");
require_once("viewModels/ViewModelBase.php");

class AnimalDetailViewModel extends ViewModelBase {
  public $IsEdit;
  public $Animal = null;
  public $Treatments = array(); // sql result or array of Treatement entities ?
  public $Examinations = array(); // sql result or array of Treatement entities ?

  public function __construct() {
    $this->isEdit = false;
    $this->animal = new AnimalEntity();
  }

  public function loadFromGet() {
    if (isset($_GET['pk'])) {
      $pk = intval($_GET['pk']);
      $this->animal = new AnimalEntity($pk);
      echo("<div>Animal pk: " . $pk . '</div>');
      echo("<div>Animal load: " . (($this->animal->IsLoadSuccess) ? 'ano ': 'ne') . '</div>');
      echo("<div>Animal loaded name: " . $this->animal->getColumnStringValue('ani_name') . '</div>');
      if (isset($_GET['edit'])) {
        $this->isEdit = true;
      }
    }
  }

  public function processAjax() {}

  public function processPost() {
    $this->animal->loadFromPostData();
  }
}

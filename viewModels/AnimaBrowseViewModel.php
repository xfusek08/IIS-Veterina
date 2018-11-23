<?php

require_once("DBEntities/AnimalEntity.php");
require_once("viewModels/ViewModelBase.php");

class AnimaBrowseViewModel extends ViewModelBase {
  public $Animals = array(); // probably just result of concrete sql

  public function loadFromGet() {}

  public function processAjax() {}

  public function processPost() {}
}

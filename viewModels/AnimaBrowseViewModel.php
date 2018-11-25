<?php

require_once("DBEntities/AnimalBrowseEntity.php");
require_once("lib/DBEntityBrowser.php");
require_once("viewModels/ViewModelBase.php");

class AnimaBrowseViewModel extends ViewModelBase {
  public $AnimalWithPlanedExamBrowser       = null;
  public $AnimalWithoutPlanedExamBrowser  = null;

  public function loadFromGet() {
    $this->AnimalWithPlanedExamBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity",   // selected entity class
      "ani_state = 'A'",      // where contition
      "exabegin",             // order by
      "exabegin > now()"      // having condition
    );
    $this->AnimalWithoutPlanedExamBrowser = new DBEntityBrowser(
      "AnimalBrowseEntity",   // selected entity class
      "ani_state = 'A'",      // where contition
      "exabegin desc",        // order by
      "exabegin < now()"      // having condition
    );
    $this->AnimalWithPlanedExamBrowser->openBrowser();
    $this->AnimalWithoutPlanedExamBrowser->openBrowser();
  }

  public function processAjax() {}

  public function processPost() {}
}

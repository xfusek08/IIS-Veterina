<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/MedicamentEntity.php");
require_once("models/MedicamentModel.php");

require_once("viewModels/base/ViewModelBase.php");

class MedicamentBrowseViewModel extends ViewModelBase {
  public $Medicaments = array();  // array of MedicamentModel
  public $SearchString = '';

  private $MedicamentBrowser = null;

  public function init() {
    $this->Owners = array();
    $this->MedicamentBrowser = new DBEntityBrowser(
      "MedicamentEntity", // selected entity class
      '',                 // where condition
      "med_name"          // order by
    );
    $this->MedicamentBrowser->openBrowser();
  }

  public function ProcessGet() {
    if (isset($_GET['search']))
      $this->SearchString = $_GET['search'];
    $this->init();
    $this->loadData();
  }

  public function loadData() {
    while (($ent = $this->MedicamentBrowser->getNext()) != null) {
      $newModel = new MedicamentModel();
      $newModel->Pk       = $ent->getColumnStringValue('med_pk');
      $newModel->Name     = $ent->getColumnStringValue('med_name');
      $newModel->Type     = $ent->getColumnStringValue('med_type_text');
      $newModel->Price    = $ent->getColumnStringValue('med_price');
      $newModel->Producer = $ent->getColumnStringValue('med_producer');

      if ($this->SearchString == '' || strpos(strtolower($newModel->Name . $newModel->Type . $newModel->Producer), strtolower($this->SearchString)) !== false)
        $this->Medicaments[] = $newModel;
    }
  }
}

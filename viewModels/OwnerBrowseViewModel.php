<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/OwnerEntity.php");
require_once("models/OwnerModel.php");

require_once("viewModels/ViewModelBase.php");

class OwnerBrowseViewModel extends ViewModelBase {
  public $Owners = array(); // array of OwnerModel
  public $SearchString = '';

  private $OwnerBrowser = null;

  public function init() {
    $this->Owners = array();
    $this->OwnerBrowser = new DBEntityBrowser(
      "OwnerEntity", // selected entity class
      "",            // where condition
      "own_surname"  // order by
    );
    $this->OwnerBrowser->openBrowser();
  }

  public function ProcessGet() {
    if (isset($_GET['search']))
      $this->SearchString = $_GET['search'];
    $this->init();
    $this->loadData();
  }

  public function loadData() {
    // TODO: filtrace na stav ??
    while (($ent = $this->OwnerBrowser->getNext()) != null) {
      $newModel = new OwnerModel();
      $newModel->Pk         = $ent->getColumnStringValue('own_pk');
      $newModel->Name       = $ent->getColumnStringValue('own_name');
      $newModel->Surname    = $ent->getColumnStringValue('own_surname');
      $newModel->Address    = $ent->getColumnStringValue('own_address');
      $newModel->Telephone  = $ent->getColumnStringValue('own_mobile_number');
      $newModel->Sex        = $ent->getColumnStringValue('own_sex');
      $newModel->IsActive   = $ent->getColumnStringValue('own_isactive');
      if ($this->SearchString == '' || strpos(strtolower($newModel->Name . $newModel->Surname . $newModel->Address . $newModel->Telephone), strtolower($this->SearchString)) !== false)
        $this->Owners[] = $newModel;
    }
  }
}

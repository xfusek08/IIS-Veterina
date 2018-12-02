<?php

require_once("lib/DBEntityBrowser.php");

require_once("DBEntities/EmployeeEntity.php");

require_once("models/EmployeeModel.php");

require_once("logic/Mapper.php");

require_once("viewModels/base/ViewModelBase.php");

class EmployeeBrowseViewModel extends ViewModelBase {
  public $Employees = array();  // array of EmployeeModel

  public $SearchString = '';

  public function ProcessGet() {
    if (isset($_GET['search']))
      $this->SearchString = $_GET['search'];
    $this->Employees = array();
    $this->loadData();
  }

  public function loadData() {
    $browser = new DBEntityBrowser(
      "EmployeeEntity",
      "",
      "emp_surname"
    );

    $browser->openBrowser();

    while (($ent = $browser->getNext()) != null) {
      $newModel = Mapper::entityToEmployeeModel($ent);
      if ($this->SearchString == '' || strpos(strtolower($newModel->Name . $newModel->Surname . $newModel->Address . $newModel->Telephone), strtolower($this->SearchString)) !== false)
        $this->Employees[] = $newModel;
    }
  }
}

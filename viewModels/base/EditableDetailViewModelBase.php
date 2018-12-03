<?php

require_once("lib/Settings.php");

require_once("viewModels/base/ViewModelBase.php");

abstract class EditableDetailViewModelBase extends ViewModelBase {
  public $IsEdit = false;
  public $Errors = array();
  public $Message = '';

  protected $MainDBEntity = null;

  private $_mainDbEntTypeString = '';

  public function __construct($mainDBEntityTypeString) {
    $this->_mainDbEntTypeString = $mainDBEntityTypeString;
    $this->MainDBEntity = new $mainDBEntityTypeString();
    if (!is_a($this->MainDBEntity, 'DatabaseEntity'))
      die("EditableDetailViewModelBase has to take DatabaseEntity type as parameter");
  }

  public function ProcessGet() {
    $this->loadGetData();
    if (isset($_GET['delete']))
      if ($this->DeleteFromDB())
        return;

    if ($this->IsEdit)
      $this->initEdit();
    else
      $this->initView();
  }

  public function processPost() {
    $this->loadGetData();
    $this->MainDBEntity->loadFromPostData();
    if (!$this->MainDBEntity->isDataValid()) {
      $this->Errors = $this->MainDBEntity->GetInvalidData();
      $this->Message = STR_MSG_FORM_INVALID_DATA;
    } else {
      if (!$this->MainDBEntity->saveToDB()) {
        $this->Message = STR_MSG_SAVE_FAILED;
      } else {
        $this->Message = STR_MSG_SAVED;
        $this->onSuccessPost();
        return;
      }
    }
    $this->initEdit();
  }

  public function loadGetData() {
    $this->Message = '';
    $pk = 0;
    if (isset($_GET['pk']))
      $pk = intval($_GET['pk']);
    $this->IsEdit = isset($_GET['edit']) || $pk == 0;
    $this->initMainDbEntity($pk);
  }

  public function initMainDbEntity($pk) {
    $this->MainDBEntity = new $this->_mainDbEntTypeString($pk);
  }

  public function DeleteFromDB() {
    if (!$this->MainDBEntity->deleteFromDB()) {
      $this->Message = STR_MSG_DELETE_FAILED;
      return false;
    }
    $this->onSuccessDelete();
    return true;
  }

  public abstract function initView();
  public abstract function initEdit();
  public abstract function onSuccessPost();
  public abstract function onSuccessDelete();

  protected function LoadEditSelectData($SQL) {
    $res = array();
    $fields = null;
    if (!MyDatabase::runQuery($fields, $SQL)) {
      die('Error while selecting from database.');
    }
    foreach ($fields as $row)
      $res[$row[0]] = $row[1];
    return $res;
  }
}

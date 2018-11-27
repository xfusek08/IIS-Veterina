<?php

require_once("lib/Settings.php");
require_once("lib/Logs.php");
require_once("lib/Database.php");
require_once("lib/DatabaseEntity.php");

/* browse entiity serves only as select builder */
class DBEntityBrowser {
  private $_templDBEntInstance;
  private $_actIndex = 0;

  public $WhereSQL  = '';
  public $OrderBySQL  = '';
  public $HavingSQL  = '';
  public $EntityTypeString = '';
  public $BrowserData = array();
  public $IsOpen = false;
  public $IsLoadedAll = false;
  public $Loaded = 0;
  public $Params = array();

  public function __construct($entityTypeString, $whereSQL = '', $orderBySQL = '', $havingSQL = '') {
    $this->EntityTypeString = $entityTypeString;
    $this->WhereSQL = $whereSQL;
    $this->OrderBySQL = $orderBySQL;
    $this->HavingSQL = $havingSQL;
    $this->_templDBEntInstance = new $entityTypeString();
  }

  public function buildBrowserSelectSQL($skip = 0 , $count = 0) {
    $SQL = $this->_templDBEntInstance->getSelectSQL();
    if (strlen($this->WhereSQL) > 0)
      $SQL .= " where $this->WhereSQL";
    if (strlen($this->HavingSQL) > 0)
      $SQL .= " having $this->HavingSQL";
    if (strlen($this->OrderBySQL) > 0)
      $SQL .= " order by $this->OrderBySQL";

    $SQL .= " LIMIT $skip";
    if ($count > 0)
      $SQL .= ", $count";
    return $SQL;
  }

  public function openBrowser($loadCount = 20) {
    $this->closeBrowser();
    $resCnt = $this->loadData(0, $loadCount);
    if ($resCnt < 0)
      return false;
    $this->IsOpen = true;
    $this->IsOnEnd = false;
    return true;
  }

  public function closeBrowser() {
    $this->BrowserData = array();
    $this->ActRowNumber = 0;
    $this->Loaded = 0;
    $this->IsOpen = false;
    $this->IsOnEnd = true;
  }

  public function getNext() {
    if (!$this->IsOpen)
      return null;
    if ($this->_actIndex >= $this->Loaded) {
      if ($this->loadData($this->Loaded, LOAD_CHUNK_SIZE) < 0)
        return null;
    }
    if ($this->_actIndex >= $this->Loaded) {
      return null;
    }
    $res = $this->BrowserData[$this->_actIndex];
    $this->_actIndex++;
    return $res;
  }

  public function addParams($params) {
    if (!is_array($params))
      $this->Params = array_merge($this->Params, $params);
    else
      $this->Params[] = $params;
  }

  private function loadData($skip = 0, $count = 0) {
    if ($this->IsLoadedAll)
      return 0;

    $SQL = $this->buildBrowserSelectSQL($skip , $count);
    $DBFields = null;
    if (!MyDatabase::RunQuery($DBFields, $SQL, $this->Params)) {
      Log::WriteLog(LogType::Error, 'DBEntityBrowser->loadData - error on select.');
      return -1;
    }

    $actLoaded = 0;
    $resultFields = array();
    foreach ($DBFields as $DBRow) {
      $dataEntity = new $this->EntityTypeString();
      foreach ($dataEntity->Columns as $col) {
        if (!$col->setValueFromString(strval($DBRow[$col->ColName]))) {
          Log::WriteLog(LogType::Error, "DBEntityBrowser->loadData - error on loading values at colum: $col->ColName.");
          return -1;
        }
      }
      $resultFields[] = $dataEntity;
      $actLoaded++;
    }

    $this->IsLoadedAll = ($count < 0) || ($actLoaded < $count);
    $this->BrowserData = array_merge($this->BrowserData, $resultFields);
    $this->Loaded += $actLoaded;
    return $actLoaded;
  }
}

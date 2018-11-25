<?php

require_once("lib/Logs.php");
require_once("lib/utils.php");

class DataType {
  const None = 0;
  const String = 1;
  const Integer = 2;
  const Float = 3;
  const Date = 4;
  const DateTrnc = 5;
  const Timestamp = 6;
  const Bool = 7;
}

class SaveToDBResult {
  const None = 0;
  const OK = 1;
  const Error = 2;
  const InvalidData = 3;
}

abstract class DatabaseEntity {
  public $PK;
  public $TableName;
  public $PKColName;

  public $Columns = array();
  public $IsLoadSuccess;
  public $SaveToDBResult;

  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->PK = $pk;
    $this->PKColName = strtolower($this->PKColName);
    $this->IsLoadSuccess = false;
    $this->SaveToDBResult = SaveToDBResult::None;
    $this->defColumns();

    if ($this->PK > 0)
      $this->IsLoadSuccess = $this->initFromDB($isExternalTransaction);
  }

  public function initFromDB($isExternalTransaction) {
    if ($this->PK < 1 || $this->TableName == '' || $this->PKColName == '')
      return false;

    $SQL = $this->getSelectSQL() . " where $this->PKColName = ?";

    $fields = null;
    if(!MyDatabase::runQuery($fields, $SQL, $isExternalTransaction, $this->PK))
      return false;

    if (count($fields) == 0 || count($fields) > 1)
      return false;

    for ($i = 0; $i < count($this->Columns); $i++) {
      if (!$this->Columns[$i]->setValueFromString(strval($fields[0][$this->Columns[$i]->ColName]))) {
        Log::WriteLog(LogType::Error,
          "Database entity initialization error on index: $i entity name: " . $this->Columns[$i]->ColName);
        return false;
      }
    }
    return true;
  }

  public function getSelectSQL() {
    $cols = array();
    foreach ($this->Columns as $col)
      $cols[] = $col->getSelectSQL();
    return 'select ' . implode(', ', $cols) . ' from ' . $this->TableName;
  }

  public function saveToDB($isExternalTransaction) {
    $this->SaveToDBResult = SaveToDBResult::OK;
    if (!$this->isDataValid()) {
      $this->SaveToDBResult = SaveToDBResult::InvalidData;
      return false;
    }

    $SQL = '';
    $cols = array();
    $params = array();

    // load cols with $this->Columns and filter out SQLColumn
    foreach ($this->Columns as $col) {
      if (!is_a($col, 'SQLColumn')) {
        $cols[] = $col->ColName;
        $params[] = $col->getValueAsString(false);
      }
    }

    // UPDATE
    if ($this->PK > 0) {
      $SQL =
        'update ' . $this->TableName . ' set ' . implode(' = ?, ', $cols) .
        ' where ' . $this->PKColName . ' = ?';
      $params[] = $this->PK;

    } else { // INSERT
      $SQL =
        'insert into ' . $this->TableName . ' (' . implode(', ', $cols) . ')' .
        ' values (' . str_repeat('?, ', count($cols)) . ')' .
        ' returning ' . $this->PKColName . ';';
    }

    $fields = null;

    if (!MyDatabase::runQuery($fields, $SQL, $isExternalTransaction, $params)) {
      $this->SaveToDBResult = SaveToDBResult::Error;
      return false;
    }

    if ($this->PK == 0) {
      if (count($fields) == 0) {
        $this->SaveToDBResult = SaveToDBResult::Error;
        return false;
      }
      $this->PK = intval($fields[0][0]);
    }

    return true;
  }

  public function deleteFromDB($isExternalTransaction) {
    if ($this->PK < 1)
      return true;

    $SQL = 'delete from ' . $this->TableName . ' where ' . $this->PKColName . ' = ?';
    $fields = null;
    if (!MyDatabase::runQuery($fields, $SQL, $isExternalTransaction, $this->PK))
      return false;
    return true;
  }

  public function getAsXML($formated = true) {
    $res = '<' . $this->TableName . '>' . PHP_EOL;
    $res .= '<pk>' . $this->PK . '</pk>' . PHP_EOL;
    foreach ($this->Columns as $col) {
      $res .=
        '<' . $col->ColName . '>'  . PHP_EOL .
          $col->getValueAsString($formated)  . PHP_EOL .
        '</' . $col->ColName . '>' . PHP_EOL;
    }
    $res .= '</' . $this->TableName . '>' . PHP_EOL;
    return $res;
  }

  // TODO: get as JSON

  public function loadFromPostData($prefix = '') {
    $counter = 0;
    foreach ($this->Columns as $col) {
      if (isset($_POST[$prefix . $col->ColName])) {
        $col->setValueFromString($_POST[$prefix . $col->ColName]);
        $counter++;
      } else if ($col->DataType == DataType::Bool)
       $col->setValue(false);
    }
    return $counter;
  }

  public function getColumnByName($colName) {
    foreach ($this->Columns as $col)
      if ($col->ColName === $colName)
        return $col;

    return null;
  }

  public function getColumnStringValue($colName) {
    $col = $this->getColumnByName($colName);
    if ($col != null)
      return $col->getValueAsString();
    return "unknown";
  }

  public function isDataValid() {
    foreach ($this->Columns as $col)
      if (!$col->IsValid)
        return false;

    return true;
  }

  public function getInvalidDataXML($prefix = '') {
    $res = '<invaliddata>';
    foreach ($this->Columns as $col) {
      if (!$col->IsValid) {
        $res .=
        '<input name="' . $prefix . $col->ColName . '" '.
          'message="' . $col->getInvalidDataMessage() . '" />';
      }
    }
    $res .= '</invaliddata>';
    return $res;
  }

  // TODO: getInvalidDataJSON

  protected function addColumn($dataType, $name, $isNotNull = false, $defValueString = '') {
    if ($this->getColumnByName($name) !== null)
        return $this->getColumnByName($name);
    $col = new DBEntColumn($dataType, $name, $isNotNull, $defValueString);
    $this->Columns[] = $col;
    return $col;
  }

  protected function addSQLColumn($dataType, $name, $stringSQL) {
    if ($this->getColumnByName($name) !== null)
      return $this->getColumnByName($name);
    $col = new SQLColumn($dataType, $name, $stringSQL);
    $this->Columns[] = $col;
    return $col;
  }

  protected abstract function defColumns();
}

class DBEntColumn {
  private $_valueVar;

  public $IsNotNull;
  public $ColName;
  public $IsValid;
  public $InvalidDataMsg;
  public $IsUnformated;
  public $DataType;

  public function __construct($dataType, $name, $isNotNull = false, $defValueString = '') {
    $this->InvalidDataMsg = '';
    $this->IsUnformated = false;
    $this->IsValid = false;
    $this->DataType = $dataType;
    $this->IsNotNull = $isNotNull;
    $this->ColName = strtolower($name);
    $this->setValueFromString($defValueString);
  }

 public function getValue() {
    return $this->_valueVar;
  }

  public function getInvalidDataMessage() {
    return $this->InvalidDataMsg;
  }

  public function getSelectSQL() {
    return $this->ColName;
  }

  public function setValue($valueVar) {
    $this->IsValid = true;

    if ($this->DataType == DataType::Bool)
      $this->_valueVar = BoolTo01($valueVar);
    else
      $this->_valueVar = $valueVar;

    if ($valueVar === '')
      $this->_valueVar = null;

    if ($this->_valueVar === null) {
      if ($this->IsNotNull) {
        $this->IsValid = false;
        $this->InvalidDataMsg = 'Položka je povinná.';
      }
      return $this->IsValid;
    }

    switch ($this->DataType) {
      case DataType::String:
        $this->IsValid = is_string($this->_valueVar);
        break;
      case DataType::Integer:
        $this->IsValid = is_int($this->_valueVar);
        break;
      case DataType::Float:
        $this->IsValid = is_float($this->_valueVar);
        break;
      case DataType::Date:
      case DataType::DateTrnc:
      case DataType::Timestamp:
        $this->IsValid = IsTimestamp($this->_valueVar);
        break;
      case DataType::Bool:
        $this->IsValid = $this->_valueVar === 1 || $this->_valueVar === 0;
        break;
    }

    if (!$this->IsValid) {
      $this->InvalidDataMsg = 'Chyba ve validaci';
      Log::WriteLog(LogType::Announcement,
          'DBEntColumn.setValue() - invalid got datatype. name="' . $this->ColName . '" '.
          'value="' . $this->_valueVar . '" NotNull="' . BoolTo01Str($this->IsNotNull) . '"');
    }

    return $this->IsValid;
  }

  public function setValueFromString($valueString) {
    if ($this->DataType == DataType::Bool)
      return $this->setValue(BoolTo01(boolval($valueString)));

    // pokud neni string tak nic nemenime a zapiseme upozorneni
    if (!is_string($valueString) && $valueString !== null) {
      Log::WriteLog(LogType::Announcement,
        'DBEntColumn.setValueFromString() - Trying to store non string value. name="' . $this->ColName . '" '.
          'value="' . $this->getValue() . '" NotNull="' . BoolTo01Str($this->IsNotNull) . '"');
      return $this->IsValid;
    }

    // prazdny string odpovida hodnote null
    if ($valueString == '' || $valueString === null)
      return $this->setValue(null);

    switch ($this->DataType) {
      case DataType::String: $this->setValue($valueString); break;
      case DataType::Integer:
        $val = str_replace(' ', '', $valueString);
        if (is_numeric ($val))
          $this->setValue(intval($val));
        else {
          $this->IsValid = false;
          $this->InvalidDataMsg = 'Položka není platné celé číslo.';
        }
        break;
      case DataType::Float:
        $val = str_replace(',', '.', $valueString);
        $val = str_replace(' ', '', $val);
        if (is_numeric ($val))
          $this->setValue(floatval($val));
        else {
          $this->IsValid = false;
          $this->InvalidDataMsg = 'Položka není platné desetinné číslo.';
        }
        break;
      case DataType::Date:
      case DataType::DateTrnc:
      case DataType::Timestamp:
        if (strtotime($valueString) == false) {
          $this->IsValid = false;
          $this->InvalidDataMsg = 'Položka není platný časový údaj.';
        }
        else
          $this->setValue(strtotime($valueString));
        break;
    }
    return $this->IsValid;
  }

  public function getValueAsString($isFormated = true) {
    if ($this->getValue() === null)
      return '';

    switch ($this->DataType) {
      case DataType::String:
        return $this->getValue();
      case DataType::Integer:
        if (!$isFormated || $this->IsUnformated) return strval($this->getValue());
        return number_format($this->getValue(), 0, '', ' ');
      case DataType::Float:
        if (!$isFormated || $this->IsUnformated)
          return number_format($this->getValue(), 2, '.', '');
        return number_format($this->getValue(), 2, ',', ' ');
      case DataType::Date:
        return date(DATE_FORMAT, $this->getValue());
      case DataType::DateTrnc:
        return date('d.m.', $this->getValue());
      case DataType::Timestamp:
        return date(DATE_TIME_FORMAT, $this->getValue());
      case DataType::Bool:
        return BoolTo01Str($this->getValue());
    }
  }
}

class SQLColumn extends DBEntColumn {
  public $i_sSQL;

  public function __construct($dataType, $name, $stringSQL) {
    parent::__construct($dataType, $name);
    $this->i_sSQL = $stringSQL;
    $this->IsValid = true;
  }

  public function getSelectSQL() {
    return '(' . $this->i_sSQL . ') as ' . $this->ColName;
  }
}

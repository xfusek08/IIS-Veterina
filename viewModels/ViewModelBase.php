<?php
/**
 * Basic View model class interface
 */

require_once("lib/Database.php");

abstract class ViewModelBase {
  public function ProcessGet() {}
  public function processAjax() {}
  public function processPost() {}

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
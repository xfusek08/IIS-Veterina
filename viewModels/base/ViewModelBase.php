<?php
/**
 * Basic View model class interface
 */

require_once("lib/Database.php");

abstract class ViewModelBase {
  public function ProcessGet() {}
  public function processAjax() {}
  public function processPost() {}
}
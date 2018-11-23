<?php
/**
 * Basic View model class interface
 */
abstract class ViewModelBase {
  public function loadFromGet() {}
  public function processAjax() {}
  public function processPost() {}
}
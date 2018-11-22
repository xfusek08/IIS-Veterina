<?php
/**
 * Basic View model class interface
 */
abstract class ViewModelBase {
  public abstract function loadFromGet();
  public abstract function processAjax();
  public abstract function processPost();
}
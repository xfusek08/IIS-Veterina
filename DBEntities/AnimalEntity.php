<?php

require_once("lib/DatabaseEntity.php");

class AnimalEntity extends DatabaseEntity {
  public function __construct($pk = 0, $externalTransaction = false) {
    $this->TableName = 'Animal';
    $this->PKColName = 'ani_pk';
    parent::__construct($pk, $externalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::String, 'ani_name', true);
    // TODO: all columns
  }
}

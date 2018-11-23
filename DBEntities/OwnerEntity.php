<?php

require_once("lib/DatabaseEntity.php");

class OwnerEntity extends DatabaseEntity {
  public function __construct($pk = 0, $externalTransaction = false) {
    $this->TableName = 'Owner';
    $this->PKColName = 'own_pk';
    parent::__construct($pk, $externalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::String, 'own_name');
    $this->addColumn(DataType::String, 'own_surname', true);
    $this->addColumn(DataType::String, 'own_sex');
    $this->addColumn(DataType::String, 'own_mobile_number');
    $this->addColumn(DataType::String, 'own_address');
    $this->addColumn(DataType::Bool,   'own_isactive', true, 'Y');
  }
}

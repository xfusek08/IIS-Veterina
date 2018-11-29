<?php

require_once("lib/DatabaseEntity.php");

class OwnerEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Owner';
    $this->PKColName = 'own_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer, 'own_pk');
    $this->addColumn(DataType::String,  'own_name');
    $this->addColumn(DataType::String,  'own_surname', true);
    $this->addColumn(DataType::String,  'own_sex');
    $this->addColumn(DataType::String,  'own_mobile_number');
    $this->addColumn(DataType::String,  'own_address');
    $this->addColumn(DataType::Bool,    'own_isactive', true, 'Y');

    $this->addSQLColumn(DataType::String, 'own_sex_text',
      'select psex_text from Person_sex where psex_shortcut = own_sex');
  }
}

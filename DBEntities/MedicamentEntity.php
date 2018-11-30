<?php

require_once("lib/DatabaseEntity.php");

class MedicamentEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Medicament';
    $this->PKColName = 'med_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,   'med_pk');
    $this->addColumn(DataType::Integer,   'med_type',             true);
    $this->addColumn(DataType::String,    'med_name',             true);
    $this->addColumn(DataType::Float,     'med_price');
    $this->addColumn(DataType::String,    'med_producer');
    $this->addColumn(DataType::String,    'med_active_substance');

    $this->addSQLColumn(DataType::String, 'med_type_text',
      'select medt_text from Medicament_type where medt_pk = med_type');
  }
}

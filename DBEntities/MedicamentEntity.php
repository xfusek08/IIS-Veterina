<?php

require_once("lib/DatabaseEntity.php");

class MedicamentEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Medicament';
    $this->PKColName = 'med_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Int,    'med_type', true);
    $this->addColumn(DataType::String, 'med_name', true);
    $this->addColumn(DataType::Float,  'med_price', true);
    $this->addColumn(DataType::String, 'med_producer', true);
    $this->addColumn(DataType::String, 'med_active_substance', true);
  }
}

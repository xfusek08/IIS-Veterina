<?php

require_once("lib/DatabaseEntity.php");

class TreatmentEntity extends DatabaseEntity {
  public function __construct($pk = 0, $externalTransaction = false) {
    $this->TableName = 'Treatment';
    $this->PKColName = 'tre_pk';
    parent::__construct($pk, $externalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Int,    'tre_animal', true);
    $this->addColumn(DataType::String, 'tre_state', true);
    $this->addColumn(DataType::String, 'tre_caption', true);
    $this->addColumn(DataType::String, 'tre_prognosis');
    $this->addColumn(DataType::Float,  'tre_price', true);
  }
}

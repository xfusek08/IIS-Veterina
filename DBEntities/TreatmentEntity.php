<?php

require_once("lib/DatabaseEntity.php");

class TreatmentEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Treatment';
    $this->PKColName = 'tre_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer, 'tre_pk');
    $this->addColumn(DataType::Integer, 'tre_animal', true);
    $this->addColumn(DataType::String,  'tre_state', true);
    $this->addColumn(DataType::String,  'tre_caption', true);
    $this->addColumn(DataType::String,  'tre_prognosis');
    $this->addColumn(DataType::Float,   'tre_price', true);

    $this->addSQLColumn(DataType::String, 'tre_state_text',
      'select tst_text from Treatment_state where tst_shortcut = tre_state');
  }
}

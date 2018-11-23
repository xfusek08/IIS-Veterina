<?php

require_once("lib/DatabaseEntity.php");

class ExaminationEntity extends DatabaseEntity {
  public function __construct($pk = 0, $externalTransaction = false) {
    $this->TableName = 'Examination';
    $this->PKColName = 'exa_pk';
    parent::__construct($pk, $externalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::String,   'exa_type', true);
    $this->addColumn(DataType::Int,      'exa_emloyee', true);
    $this->addColumn(DataType::Int,      'exa_animal', true);
    $this->addColumn(DataType::DateTime, 'exa_begin_date_time', true);
    $this->addColumn(DataType::Int,      'exa_duration_minutes', true);
    $this->addColumn(DataType::Float,    'exa_price', true);
    $this->addColumn(DataType::Bool,     'exa_occurred', true);
    $this->addColumn(DataType::String,   'exa_final_report');
  }
}

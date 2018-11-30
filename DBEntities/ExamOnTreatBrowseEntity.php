<?php

require_once("lib/DatabaseEntity.php");

class ExamOnTreatBrowseEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName =
      'Treatment_on_Examination' .
      ' join Examination on exa_pk = toe_exapk'.
      ' join Examination_type on exa_shortcut = exa_type';
    $this->PKColName = '';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,   'toe_trepk', true);
    $this->addColumn(DataType::Integer,   'toe_exapk', true);
    $this->addColumn(DataType::String,    'toe_ongoing_diagnosis');
    $this->addColumn(DataType::Integer,   'exa_pk');
    $this->addColumn(DataType::String,    'exa_text');
    $this->addColumn(DataType::Timestamp, 'exa_begin_date_time');
    $this->addColumn(DataType::Float,     'exa_price');
    $this->addColumn(DataType::Bool,      'exa_occurred');
  }
}

<?php

require_once("lib/DatabaseEntity.php");

class TreatmentOnExaminationEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Treatment_on_Examination';
    $this->PKColName = '';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer, 'toe_trepk', true);
    $this->addColumn(DataType::Integer, 'toe_exapk', true);
    $this->addColumn(DataType::String,  'toe_ongoing_diagnosis');
  }
}

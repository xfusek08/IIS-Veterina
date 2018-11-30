<?php

require_once("lib/DatabaseEntity.php");

class MedOnTreatBrowseEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName =
      'Medicament_on_Treatment' .
      ' left join Medicament on med_pk = mot_medpk';
    $this->PKColName = '';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer, 'mot_medpk',  true);
    $this->addColumn(DataType::Integer, 'mot_trepk',   true);
    $this->addColumn(DataType::String,  'med_name',       true);
    $this->addColumn(DataType::String,  'med_type',       true);
    $this->addColumn(DataType::Float,   'med_price',      true);
    $this->addColumn(DataType::String,  'mot_dosage');
    $this->addColumn(DataType::String,  'mot_usage_time');
  }
}

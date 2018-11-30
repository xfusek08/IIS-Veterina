<?php

require_once("lib/DatabaseEntity.php");

class ExaminationEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Examination';
    $this->PKColName = 'exa_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,   'exa_pk');
    $this->addColumn(DataType::Integer,   'exa_employee'        , true);
    $this->addColumn(DataType::Integer,   'exa_animal'          , true);
    $this->addColumn(DataType::String,    'exa_type'            , true);
    $this->addColumn(DataType::Timestamp, 'exa_begin_date_time' , true);
    $this->addColumn(DataType::Integer,   'exa_duration_minutes', true);
    $this->addColumn(DataType::Float,     'exa_price'           , true);
    $this->addColumn(DataType::Bool,      'exa_occurred'        , true);
    $this->addColumn(DataType::String,    'exa_final_report');

    $this->addSQLColumn(DataType::String, 'exa_type_text',
      "select exa_text from Examination_type where exa_shortcut = exa_type");
    $this->addSQLColumn(DataType::String, 'employee_name',
      "select concat(emp_surname, ' ', coalesce(emp_name, '')) from Employee where emp_pk = exa_employee");
    $this->addSQLColumn(DataType::String, 'animal_name',
      "select ani_name from Animal where ani_pk = exa_animal");
    }
}

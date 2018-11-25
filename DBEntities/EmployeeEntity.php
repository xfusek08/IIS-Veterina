<?php

require_once("lib/DatabaseEntity.php");

class EmployeeEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Employee';
    $this->PKColName = 'emp_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Int,     'emp_state'   , true);
    $this->addColumn(DataType::Int,     'emp_position', true, 'W');
    $this->addColumn(DataType::String,  'emp_name');
    $this->addColumn(DataType::String,  'emp_surname' , true);
    $this->addColumn(DataType::String,  'emp_sex'     , true);
    $this->addColumn(DataType::String,  'emp_mobile_number');
    $this->addColumn(DataType::String,  'emp_address');
    $this->addColumn(DataType::Float,   'emp_wage'    , true);
    $this->addColumn(DataType::Date,    'emp_birthday');
    $this->addColumn(DataType::Bool,    'emp_isadmin' , true, 'N');
    $this->addColumn(DataType::String,  'emp_username');
    $this->addColumn(DataType::String,  'emp_password');
  }
}

<?php

require_once("lib/DatabaseEntity.php");

class AnimalEntity extends DatabaseEntity {
  public function __construct($pk = 0, $externalTransaction = false) {
    $this->TableName = 'Animal';
    $this->PKColName = 'ani_pk';
    parent::__construct($pk, $externalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Int, 'ani_owner', true);
    $this->addColumn(DataType::Int, 'ani_species', true);
    $this->addColumn(DataType::String, 'ani_state', true, 'A');
    $this->addColumn(DataType::String, 'ani_description');
    $this->addColumn(DataType::String, 'ani_name', true);
    $this->addColumn(DataType::String, 'ani_sex');
    $this->addColumn(DataType::Int, 'ani_weight');
    $this->addColumn(DataType::Date, 'ani_birthday');
    $this->addColumn(DataType::Int, 'ani_race');
  }
}

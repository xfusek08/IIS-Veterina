<?php

require_once("lib/DatabaseEntity.php");

class AnimalEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Animal';
    $this->PKColName = 'ani_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,   'ani_owner',   true);
    $this->addColumn(DataType::Integer,   'ani_species', true);
    $this->addColumn(DataType::String,    'ani_state',   true, 'A');
    $this->addColumn(DataType::String,    'ani_description');
    $this->addColumn(DataType::String,    'ani_name',    true);
    $this->addColumn(DataType::String,    'ani_sex');
    $this->addColumn(DataType::Integer,   'ani_weight');
    $this->addColumn(DataType::Date,      'ani_birthday');
    $this->addColumn(DataType::Integer,   'ani_race');

    $this->addSQLColumn(DataType::String, 'ani_state_text',
      'select ast_text from Animal_state where ast_shortcut = ani_state');
    $this->addSQLColumn(DataType::String, 'ani_sex_text',
      'select asex_description from Animal_state where asex_shortcut = ani_sex');
    $this->addSQLColumn(DataType::String, 'owner_name',
      "select concat(own_surname, ' ', coalesce(own_name, '')) from Owner where own_pk = ani_owner");  }
}

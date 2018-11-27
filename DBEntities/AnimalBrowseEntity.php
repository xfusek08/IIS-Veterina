<?php

require_once("lib/DatabaseEntity.php");

class AnimalBrowseEntity extends DatabaseEntity {
  public function __construct() {
    $this->TableName =
      'Animal' .
      ' left join Owner on own_pk = ani_owner'.
      ' left join Animal_species on spe_pk = ani_species'.
      ' left join Animal_sex on asex_shortcut = ani_sex';
    $this->PKColName = 'ani_pk';
    parent::__construct(0, false);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,       'ani_pk');
    $this->addSQLColumn(DataType::String,     'ownername',
      "concat(own_surname, ' ', coalesce(own_name, ''))");
    $this->addColumn(DataType::String,        'spe_name');
    $this->addColumn(DataType::String,        'ani_name');
    $this->addColumn(DataType::String,        'asex_description');
    $this->addSQLColumn(DataType::Timestamp,  'exabegin',
      'select max(exa_begin_date_time) from Examination where exa_animal = ani_pk');
    $this->addSQLColumn(DataType::Integer,    'treatmentcnt',
      'select count(*) from Treatment where tre_animal = ani_pk');
  }

  public function SaveToDB() {
    Log::WriteLog(LogType::Error, "Call SaveToDB on AnimalBrowseEntity");
    return false;
  }
}

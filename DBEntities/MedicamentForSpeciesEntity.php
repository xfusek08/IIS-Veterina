<?php

require_once("lib/DatabaseEntity.php");

class MedicamentForSpeciesEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName =
      'Medicament_for_Speecies' .
      ' left join Animal_species on spe_pk = species_pk  ';
    $this->PKColName = '';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer, 'mfs_pk',                true);
    $this->addColumn(DataType::Integer, 'medicament_pk',         true);
    $this->addColumn(DataType::Integer, 'species_pk',            true);
    $this->addColumn(DataType::String,  'spe_name',              true);
    $this->addColumn(DataType::String,  'mfs_recommended_dosis', true);
    $this->addColumn(DataType::String,  'mfs_effective_against', true);
  }
}

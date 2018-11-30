<?php

require_once("lib/DatabaseEntity.php");

class MedicamentForSpeciesEntity extends DatabaseEntity {
  public function __construct($pk = 0, $isExternalTransaction = false) {
    $this->TableName = 'Medicament_for_Species';
    $this->PKColName = 'mfs_pk';
    parent::__construct($pk, $isExternalTransaction);
  }

  protected function defColumns() {
    $this->addColumn(DataType::Integer,   'mfs_pk');
    $this->addColumn(DataType::Integer,   'mfs_medpk',             true);
    $this->addColumn(DataType::Integer,   'mfs_spepk',             true);
    $this->addColumn(DataType::String,    'mfs_recommended_dosis', true);
    $this->addColumn(DataType::String,    'mfs_effective_against', true);
    $this->addSQLColumn(DataType::String, 'spe_name',
      'select spe_name from Animal_species where spe_pk = mfs_spepk');
  }
}

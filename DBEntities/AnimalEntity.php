<?php

class AnimalEntity extends DatabaseEntity {
  public function __construct($a_iPK = 0, $ExternTransaction = false)
  {
    $this->i_sTableName = 'Animals';
    $this->i_sPKColName = 'ani_pk';
    parent::__construct($a_iPK, $ExternTransaction);
  }
  protected function DefColumns()
  {
    $this->AddColumn(DataType::String, 'orcust_ident');
    $this->AddColumn(DataType::String, 'orcust_firma');
    $this->AddColumn(DataType::String, 'orcust_firma2');
    $this->AddColumn(DataType::String, 'orcust_mesto');
    $this->AddColumn(DataType::String, 'orcust_pozn1');
    $this->AddColumn(DataType::String, 'orcust_pozn2');
    $this->AddColumn(DataType::String, 'orcust_psc');
    $this->AddColumn(DataType::String, 'orcust_stat');
    $this->AddColumn(DataType::String, 'orcust_ulice');
    $this->AddColumn(DataType::String, 'orcust_ico');
    $this->AddColumn(DataType::String, 'orcust_dico');
    $this->AddColumn(DataType::String, 'orcust_color');
    $this->AddColumn(DataType::String, 'orcust_telefon');
    $this->AddColumn(DataType::String, 'orcust_mail');
    $this->AddColumn(DataType::String, 'orcust_prijemproc', true, '0');
  }
}

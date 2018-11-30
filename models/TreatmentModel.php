<?php

class TreatmentModel {
  public $TrePk = 0;
  public $Caption = '';
  public $State = '';
  public $Price = '';
  public $Prognosis = '';
  public $Medicaments = array(); // array of MedicamentOnTreatmentModel
}

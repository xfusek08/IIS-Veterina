
<?php

require_once("lib/DBEntityBrowser.php");
require_once("DBEntities/AnimalBrowseEntity.php");
require_once("models/AnimalBrowseModel.php");
require_once("models/AnimalModel.php");
require_once("models/ExaminationModel.php");
require_once("models/MedicamentForSpeciesModel.php");
require_once("models/EmployeeModel.php");

class Mapper {

  public static function loadAnimalEntityBrowserToModelList($browser, $searchString = '') {
    if ($browser === null || !is_a($browser, 'DBEntityBrowser'))
      die('loadAnimalEntityBrowserToModelList expect instance of DBEntityBrowser.');

    if ($browser->getEntityTypeString() != 'AnimalBrowseEntity')
      die('loadAnimalEntityBrowserToModelList passed browser has to carry instances of AnimalBrowseEntity.');

    $res = array();
    while (($actEnt = $browser->getNext()) !== null) {
      $actModel = self::entityToAnimalBrowseModel($actEnt);
      if (
        $searchString == '' ||
        strpos(strtolower(
          $actModel->AnimalName . $actModel->OwnerName . $actModel->LatestExamination),
          strtolower($searchString)
        ) !== false
      ) {
        $res[] = $actModel;
      }
    }
    return $res;
  }

  public static function entityToAnimalBrowseModel($entity) {
    $newModel = new AnimalBrowseModel();
    $newModel->Pk                 = $entity->getColumnStringValue('ani_pk');
    $newModel->AnimalName         = $entity->getColumnStringValue('ani_name');
    $newModel->OwnerName          = $entity->getColumnStringValue('ownername');
    $newModel->Species            = $entity->getColumnStringValue('spe_name');
    $newModel->Sex                = $entity->getColumnStringValue('asex_description');
    $newModel->State              = $entity->getColumnStringValue('ast_text');
    $newModel->TreatmentNumber    = $entity->getColumnStringValue('treatmentcnt');
    $newModel->LatestExamination  = $entity->getColumnStringValue('exabegin');
    return $newModel;
  }

  public static function entityToAnimalModel($entity) {
    $newModel = new AnimalModel();
    $newModel->Pk         = $entity->getColumnByName('ani_pk')->getValue();
    $newModel->OwnerPk    = $entity->getColumnByName('ani_owner')->getValue();
    $newModel->Name       = $entity->getColumnStringValue('ani_name');
    $newModel->OwnerName  = $entity->getColumnStringValue('owner_name');
    $newModel->Species    = $entity->getColumnStringValue('ani_species_text');
    $newModel->Sex        = $entity->getColumnStringValue('ani_sex_text');
    $newModel->Weight     = $entity->getColumnStringValue('ani_weight');
    $newModel->State      = $entity->getColumnStringValue('ani_state_text');
    $newModel->Birthday   = $entity->getColumnStringValue('ani_birthday');
    $newModel->Race       = $entity->getColumnStringValue('ani_race');

    $birthdate = $entity->getColumnByName('ani_birthday')->getValue();
    if ($newModel->Birthday != null) {
      $now = new DateTime();
      $newModel->Age = $now->diff($birthdate)->y;
    }
    return $newModel;
  }

  public static function entityToExaminationModel($entity) {
    $newModel = new ExaminationModel();

    $dateOcurred = $entity->getColumnByName('exa_begin_date_time')->getValue();

    $newModel->Pk            = $entity->getColumnByName('exa_pk')->getValue();
    $newModel->AnimalPK      = $entity->getColumnByName('exa_animal')->getValue();
    $newModel->EmployeePK    = $entity->getColumnByName('exa_employee')->getValue();
    $newModel->AnimalName    = $entity->getColumnStringValue('animal_name');
    $newModel->EmployeeName  = $entity->getColumnStringValue('employee_name');
    $newModel->Type          = $entity->getColumnStringValue('exa_type_text');
    $newModel->Duration      = $entity->getColumnStringValue('exa_duration_minutes');
    $newModel->Price         = $entity->getColumnStringValue('exa_price');
    $newModel->Report        = $entity->getColumnStringValue('exa_final_report');
    $newModel->Occurred      = $entity->getColumnStringValue('exa_occurred');

    if ($dateOcurred != null) {
      $newModel->Date        = $dateOcurred->format(DATE_FORMAT);
      $newModel->BeginTime   = $dateOcurred->format("H:i");
      $newModel->EndTime     = $dateOcurred->modify("+$newModel->Duration minutes")->format("H:i");
    }

    return $newModel;
  }

  public static function entityToMedicamentModel($entity) {
    $newModel = new MedicamentModel();
    $newModel->Pk       = $entity->getColumnByName('med_pk')->getValue();
    $newModel->Name     = $entity->getColumnStringValue('med_name');
    $newModel->Type     = $entity->getColumnStringValue('med_type_text');
    $newModel->Price    = $entity->getColumnStringValue('med_price');
    $newModel->Producer = $entity->getColumnStringValue('med_producer');
    return $newModel;
  }

  public static function entityToMedicamentForSpeciesModel($entity) {
    $newModel = new MedicamentForSpeciesModel();
    $newModel->Pk                = $entity->getColumnByName('mfs_pk')->getValue();
    $newModel->MedPk             = $entity->getColumnByName('mfs_medpk')->getValue();
    $newModel->SpeciesPK         = $entity->getColumnByName('mfs_spepk')->getValue();
    $newModel->Species           = $entity->getColumnStringValue('spe_name');
    $newModel->RecommendedDose   = $entity->getColumnStringValue('mfs_recommended_dosis');
    $newModel->EffectiveAgainst  = $entity->getColumnStringValue('mfs_effective_against');
    return $newModel;
  }

  public static function entityToEmployeeModel($entity) {
    $newModel = new EmployeeModel();
    $newModel->Pk         = $entity->getColumnByName('emp_pk')->getValue();
    $newModel->Name       = $entity->getColumnStringValue('emp_name');
    $newModel->Surname    = $entity->getColumnStringValue('emp_surname');
    $newModel->State      = $entity->getColumnStringValue('emp_state_text');
    $newModel->Address    = $entity->getColumnStringValue('emp_address');
    $newModel->Telephone  = $entity->getColumnStringValue('emp_mobile_number');
    $newModel->Sex        = $entity->getColumnStringValue('emp_sex_text');
    $newModel->Position   = $entity->getColumnStringValue('emp_position_text');
    $newModel->Wage       = $entity->getColumnStringValue('emp_wage');
    $newModel->Birthday   = $entity->getColumnStringValue('emp_birthday');
    $newModel->IsAdmin    = $entity->getColumnStringValue('emp_isadmin');
    $newModel->UserName   = $entity->getColumnStringValue('emp_username');
    $newModel->Password   = $entity->getColumnStringValue('emp_password');
    return $newModel;
  }
}

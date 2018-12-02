
<?php

require_once("lib/DBEntityBrowser.php");
require_once("DBEntities/AnimalBrowseEntity.php");
require_once("models/AnimalBrowseModel.php");
require_once("models/ExaminationModel.php");
require_once("models/MedicamentForSpeciesModel.php");

class Mapper {

  public static function loadAnimalEntityBrowserToModelList($browser, $searchString = '') {
    if ($browser === null || !is_a($browser, 'DBEntityBrowser'))
      die('loadAnimalEntityBrowserToModelList expect instance of DBEntityBrowser.');

    if ($browser->getEntityTypeString() != 'AnimalBrowseEntity')
      die('loadAnimalEntityBrowserToModelList passed browser has to carry instances of AnimalBrowseEntity.');

    $res = array();
    while (($actEnt = $browser->getNext()) !== null) {
      $actModel = self::entityToAnimalModel($actEnt);
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

  public static function entityToAnimalModel($entity) {
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

  public static function entityToExaminationModel($entity) {
    $dateOcurred = new DateTime();
    $dateOcurred->setTimestamp($entity->getColumnByName('exa_begin_date_time')->getValue());

    $newModel = new ExaminationModel();
    $newModel->Pk            = $entity->getColumnByName('exa_pk')->getValue();
    $newModel->AnimalPK      = $entity->getColumnByName('exa_animal')->getValue();
    $newModel->EmployeePK    = $entity->getColumnByName('exa_employee')->getValue();
    $newModel->AnimalName    = $entity->getColumnStringValue('animal_name');
    $newModel->EmployeeName  = $entity->getColumnStringValue('employee_name');
    $newModel->Type          = $entity->getColumnStringValue('exa_type_text');
    $newModel->Duration      = $entity->getColumnStringValue('exa_duration_minutes');
    $newModel->Date          = $dateOcurred->format(DATE_FORMAT);
    $newModel->BeginTime     = $dateOcurred->format("H:i");
    $newModel->EndTime       = $dateOcurred->modify("+$newModel->Duration minutes")->format("H:i");
    $newModel->Price         = $entity->getColumnStringValue('exa_price');
    $newModel->Report        = $entity->getColumnStringValue('exa_final_report');
    $newModel->Occurred      = $entity->getColumnStringValue('exa_occurred');

    return $newModel;
  }

  public static function entityToMedicamentModel($entity) {
    $newModel = new MedicamentForSpeciesModel();
    $newModel->Pk                = $entity->getColumnByName('mfs_pk')->getValue();;
    $newModel->MedPk             = $entity->getColumnByName('mfs_medpk')->getValue();;
    $newModel->SpeciesPK         = $entity->getColumnByName('mfs_spepk')->getValue();;
    $newModel->Species           = $entity->getColumnStringValue('spe_name');
    $newModel->RecommendedDose   = $entity->getColumnStringValue('mfs_recommended_dosis');
    $newModel->EffectiveAgainst  = $entity->getColumnStringValue('mfs_effective_against');
    return $newModel;
  }
}

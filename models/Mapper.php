
<?php

require_once("lib/DBEntityBrowser.php");
require_once("DBEntities/AnimalBrowseEntity.php");
require_once("models/AnimalBrowseModel.php");

class Mapper {

  public static function loadAnimalEntityBrowserToModelList($browser, $searchString = '') {
    if ($browser === null || !is_a($browser, 'DBEntityBrowser'))
      die('loadAnimalEntityBrowserToModelList expect instance of DBEntityBrowser.');

    if ($browser->getEntityTypeString() != 'AnimalBrowseEntity')
      die('loadAnimalEntityBrowserToModelList passed browser has to carry instances of AnimalBrowseEntity.');

    $res = array();
    while (($actEnt = $browser->getNext()) !== null) {
      $actModel = new AnimalBrowseModel();
      $actModel->Pk                 = $actEnt->getColumnStringValue('ani_pk');
      $actModel->AnimalName         = $actEnt->getColumnStringValue('ani_name');
      $actModel->OwnerName          = $actEnt->getColumnStringValue('ownername');
      $actModel->Species            = $actEnt->getColumnStringValue('spe_name');
      $actModel->Sex                = $actEnt->getColumnStringValue('asex_description');
      $actModel->State              = $actEnt->getColumnStringValue('ast_text');
      $actModel->TreatmentNumber    = $actEnt->getColumnStringValue('treatmentcnt');
      $actModel->LatestExamination  = $actEnt->getColumnStringValue('exabegin');

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

}

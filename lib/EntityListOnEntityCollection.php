<?php

class EntityListOnEntityCollection {
  private $_entityList = array();
  private $_toDeleteEntities = array();
  private $_loadErrorList = array();
  private $_mapperFunctionString = '';
  private $_entityTypeString = '';

  public function getEntityList()   { return $this->_entityList;  }
  public function getErrorLoadList()        { return $this->_loadErrorList; }
  public function countEntities()           { return count($this->_entityList); }
  public function countToDeleteEntities()   { return count($this->_toDeleteEntities); }
  public function getModelList()  {
    $res = array();
    foreach ($this->_entityList as $entity)
      $res[] = call_user_func($this->_mapperFunctionString, $entity);
    return $res;
  }

  public function __construct($entityTypeString, $mapperFunctionString) {
    $this->_mapperFunctionString = $mapperFunctionString;
    $this->_entityTypeString = $entityTypeString;
  }

  public function addEntity($entity) {
    $this->_entityList[] = $entity;
  }

  public function addEntityByPK($entityPK) {
    $entity = new $this->_entityTypeString($entityPK);
    $this->addEntity($entity);
    return $entity;
  }

  public function findEntityByPK($entityPK) {
    foreach ($this->_entityList as $entity) {
      if ($entity->Pk == $entityPK)
        return $entity;
    }
    return null;
  }

  public function addOrFindEntityByPK($entityPK) {
    $entity = $this->findEntityByPK($entityPK);
    if ($entity === null)
      $entity = $this->addEntityByPK($entityPK);
    return $entity;
  }

  public function clearAll() {
    $this->_entityList = array();
    $this->_toDeleteEntities = array();
  }

  public function loadFromPostData($count) {
    $isAllSuccess = true;
    $this->_toDeleteEntities = array();

    foreach ($this->_entityList as $actEntity) {
      $this->_toDeleteEntities[] = $actEntity;
    }

    $index = 0;
    while ($index < $count) {
      $prefix = '';
      if ($index != 0)
        $prefix = $index . '_';

      $actPK = getIntFromPost($prefix . $this->getEntityPKColName());
      $actEntity = null;

      if ($actPK > 0)
        $actEntity = $this->addOrFindEntityByPK($actPK);
      else
        $actEntity = $this->addEntityByPK(0);

      $toDelEntIndex = array_search($actEntity, $this->_toDeleteEntities);
      if ($toDelEntIndex !== false)
        unset($this->_toDeleteEntities[$toDelEntIndex]);

      $actEntity->loadFromPostData($prefix);
      $isAllSuccess = $isAllSuccess && $actEntity->isDataValid();
      $this->_loadErrorList = array_merge($this->_loadErrorList, $actEntity->GetInvalidData($prefix));
      $index = $index + 1;
    }
    return $isAllSuccess;
  }

  public function saveToDB($isExternalTransaction = false) {
    try {
      if (!$isExternalTransaction)
        MyDatabase::$PDO->beginTransaction();

      foreach ($this->_toDeleteEntities as $entity) {
        if (!$entity->deleteFromDB(true))
          throw new Exception("Entity with pk: $entity->Pk failed to be deleted from DB.");
      }

      foreach ($this->_entityList as $entity) {
        if (!$entity->saveToDB(true))
          throw new Exception("Entity with pk: $entity->Pk failed to be saved to DB.");
      }

      if (!$isExternalTransaction)
        MyDatabase::$PDO->commit();
    } catch (Exception $e) {
      if (!$isExternalTransaction) {
        Log::WriteLog(LogType::Error, $e->getMessage());
        Log::WriteLog(LogType::Announcement, "RollBack");
        MyDatabase::$PDO->rollBack();
      } else {
        throw $e;
      }
    }

  }

  private function getEntityPKColName() {
    $entity = new $this->_entityTypeString(0);
    return $entity->PKColName;
  }
}
<?php

class EntityListOnEntityCollection {
  private $_medicamentEntities = array();
  private $_toDeleteEntities = array();
  private $_loadErrorList = array();
  private $_mapperFunction = '';
  private $_entityTypeString = '';

  public function getMedicamentEntities()   { return $this->_medicamentEntities;  }
  public function getErrorLoadList()        { return $this->_loadErrorList; }
  public function countEntities()           { return count($this->_medicamentEntities); }
  public function countToDeleteEntities()   { return count($this->_toDeleteEntities); }
  public function getMedicamentModelList()  {
    $res = array();
    foreach ($this->_medicamentEntities as $entity)
      $res[] = $this->_mapperFunction($entity);
    return $res;
  }

  public function __construct($entityTypeString, $mapperFunction) {
    $this->_mapperFunction = $mapperFunction;
    $this->_entityTypeString = $entityTypeString;
  }

  public function addEntity($entity) {
    $this->_medicamentEntities[] = $entity;
  }

  public function addEntityByPK($entityPK) {
    $entity = new $this->_entityTypeString($entityPK);
    $this->addEntity($entity);
    return $entity;
  }

  public function findEntityByPK($entityPK) {
    foreach ($this->_medicamentEntities as $entity) {
      if ($entity->Pk == $entityPK)
        return $entity;
    }
    return null;
  }

  public function addOrFindEntityByPK($entityPK) {
    $entity = $this->findEntityByPK($entityPK);
    if ($entity === null)
      $entity = addEntityByPK($entityPK);
    return $entity;
  }

  public function clearAll() {
    $this->_medicamentEntities = array();
    $this->_toDeleteEntities = array();
  }

  public function loadFromPostData($count) {
    $isAllSuccess = true;
    $this->_toDeleteEntities = array();

    foreach ($this->_medicamentEntities as $actEntity) {
      $this->_toDeleteEntities[] = $actEntity;
    }

    $index = 0;
    while ($index < $cnt) {
      $prefix = '';
      if ($index != 0)
        $prefix = $index . '_';

      $actPK = getIntFromPost($prefix . $this->getEntityPKColName());

      $actEntity = null;
      if ($actPK > 0) {
        $actEntity = $this->addOrFindEntityByPK($actPK);
      } else {
        $actEntity = $this->addEntityByPK(0);
      }

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

  private function getEntityPKColName() {
    $entity = new $this->_entityTypeString(0);
    return $entity->PKColName;
  }
}
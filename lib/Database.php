<?php
class MyDatabase {
  const DUPLICATE_CODE = 1062;
  public static $DBFullPath = DATABASE_FULL_CONN_STR;
  public static $UserName = DATABASE_USER;
  public static $Password = DATABASE_PASSWORD;
  public static $PDO;
  public static $isConnected = false;


  public static function connect() {
    if (!isset(self::$PDO)) {
      $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // with firebird has issues with datetime types in query
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_AUTOCOMMIT => 0
      );

      try {
        self::$PDO = new PDO(DATABASE_FULL_CONN_STR,
          self::$UserName,
          self::$Password,
          $settings);
      }
      catch (PDOException $e) {
        Log::WriteLog(LogType::Error, "Database connection error; " . $e->getMessage());
        echo $e->getMessage() . '</br>';
        die("Database connection failed");
      }
      self::$isConnected = true;
    }
  }

  public static function disconnect() {
    self::$PDO = null;
    self::$isConnected = false;
  }

  public static function runQuery(&$fields, $SQL, $isExternalTransaction = false, $params = false) {
    Log::WriteLog(LogType::Announcement, "MyDatabase->runQuery; SQL:" . $SQL);
    Log::WriteLog(LogType::Announcement, "MyDatabase->runQuery; params:". PHP_EOL . print_r($params, true));

    $fields = null;
    try {
      if (!$isExternalTransaction)
        self::$PDO->beginTransaction();

      $query = self::$PDO->prepare($SQL);

      if (!$params)
        $query->execute();

      else if (!is_array($params))
        $query->execute(array($params));

      else
        $query->execute($params);

      if ($query->columnCount() > 0)
        $fields = $query->fetchAll();
      else
        $fields = array();

      Log::WriteLog(LogType::Announcement, "MyDatabase->runQuery; results:". PHP_EOL . print_r($fields, true));

      if (!$isExternalTransaction)
        self::$PDO->commit();
    }
    catch(PDOException $e) {
      Log::WriteLog(LogType::Error, "MyDatabase->runQuery; " . $e->getMessage());
      Log::WriteLog(LogType::Error, "MyDatabase->runQuery; SQL: " . $SQL);
      if (!$isExternalTransaction) {
        Log::WriteLog(LogType::Announcement, "RollBack");
        self::$PDO->rollBack();
      }
      $fields = $e->errorInfo[1];
      return false;
    }
    return true;
  }

  public static function getOneValue(&$Val, $SQL, $params = false) {
    $fields = null;

    if (!self::runQuery($fields, $SQL, false, $params)) {
      return false;
    }

    if ($fields) {
      $Val = $fields[0][0];
    }
    return true;
  }

}

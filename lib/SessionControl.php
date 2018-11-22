<?php
require_once("Settings.php");
require_once("Logs.php");
require_once("Database.php");

/* Singleton class to control session related operations */
class SessionControl {
  private static $_wasStarted = false;

  public static function startSession() {
    if (!self::$_wasStarted) {
      session_start();
      MyDatabase::connect();
    }
  }

  public static function destroySession() {
    if (self::$_wasStarted) {
      session_destroy();
      MyDatabase::disconnect();
    }
  }

  public static function isLogged() {
    if (isset($_SESSION['userPK']))
      if ($_SESSION['userPK'] > 0)
        return true;
    return false;
  }

  public static function isAjaxRequest() {}

  public static function isPostRequest() {
    return isset($_POST['post_submit']);
  }

  public static function login($userName, $password) {
    $loginRes = null;
    Logging::WriteLog(LogType::Announcement, "Login attempt for user: \"$userName\"");
    if (!MyDatabase::getOneValue($loginRes, LOGIN_SQL, array($userName, $password))) {
      self::navigate(LOGIN_PAGE . "?message=" . urlencode(STR_DATABASE_ERROR));
    }
    $loginRes = intval($loginRes);
    if ($loginRes > 0) {
      Logging::WriteLog(LogType::Announcement, "Login successful");
      $_SESSION['userPK'] = $loginRes;
      return true;
    }
    Logging::WriteLog(LogType::Announcement, "Login failed");
    return false;
  }

  public static function logout() {
    self::destroySession();
    self::navigate(LOGIN_PAGE);
  }

  public static function navigate($pageURL) {
    Logging::WriteLog(LogType::Announcement, "Forced navigation to: \"" . $pageURL . "\".");
    header("Refresh:0; url=" . $pageURL);
    die();
  }

  public static function initViewModel($VMTypeString) {
    $actVM = new $VMTypeString();
    if (self::isAjaxRequest())
      $actVM->processAjax();
    else if (self::isPostRequest())
      $actVM->processPost();
    else
      $actVM->loadFromGet();
    return $actVM;
  }

  public static function pageInitRoutine($VMTypeString) {
    self::startSession();
    if (!self::isLogged())
      self::navigate(LOGIN_PAGE);
    return self::initViewModel($VMTypeString);
  }
}

<?php
require_once("Settings.php");
require_once("Logs.php");

/* Singleton class to control session related operations */
class SessionControl {
  private static $_wasStarted = false;

  public static function startSession() {
    if (!SessionControl::$_wasStarted)
      session_start();
  }

  public static function destroySession() {
    if (SessionControl::$_wasStarted)
      session_destroy();
  }

  public static function isLogged() {
    return false;
  }

  public static function isAjaxRequest() {}

  public static function isPostRequest() {}

  public static function checkLogin() {}

  public static function navigate($pageURL) {
    Logging::WriteLog(LogType::Announcement, "Forced navigation to: \"" . $pageURL . "\".");
    header("Refresh:0; url=" . $pageURL);
    die();
  }

  public static function initViewModel($VMTypeString) {
    $actVM = new $VMTypeString();
    $actVM->loadFromGet();
    if (SessionControl::isAjaxRequest())
      $actVM->processAjax();
    else if (SessionControl::isPostRequest())
      $actVM->processPost();
    return $actVM;
  }

  public static function pageInitRoutine($VMTypeString) {
    SessionControl::startSession();
    if (!SessionControl::isLogged())
      SessionControl::navigate(LOGIN_PAGE);
    return initViewModel($VMTypeString);
  }
}

<?php
/**
 * Singleton class to control session related operations
 */
require_once("Settings.php");

class SessionControl {
  private $_wasStarted = false;

  public static function startSession() {}

  public static function destroySession() {}

  public static function isLogged() {}

  public static function checkLogin() {}

  public static function navigate() {
    header("Refresh:0; url=$LOGIN_PAGE");
    die();
  }

  public static function loginCheckRoutine() {
    SessionControl::startSession();
    if (!SessionControl::isLogged())
      SessionControl::navigate(LOGIN_PAGE);
  }
}

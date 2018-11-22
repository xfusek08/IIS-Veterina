<?php

// Time formats
define("DATE_TIME_FORMAT", "d.m.Y H:i:s");
define("DATE_FORMAT", "d.m.Y");

// Time zone
date_default_timezone_set('Europe/Prague');

// LOGS
define("LOG_FOLDER", "log");

// PAGE CONSTANTS
define("LOGIN_PAGE", "login.view.php");
define("MAIN_PAGE", "animalBrowse.view.php");

// DATABASE
define("DATABASE_FULL_CONN_STR", "mysql:host=localhost;dbname=xfusek08;port=/var/run/mysql/mysql.sock");
define("DATABASE_USER", "xfusek08");
define("DATABASE_PASSWORD", "9anrofej");

// SQL
define("LOGIN_SQL", "select emp_pk from Employee where emp_username = ? and emp_password = ?");


// STRINGS
define("STR_DATABASE_ERROR" , "Chyba databáze");

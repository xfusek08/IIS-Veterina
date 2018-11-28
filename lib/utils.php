<?php

function boolToANStr($var) {
  if ($var == true)
    return 'A';
  else
    return 'N';
}

function strToBool($str) {
  $trueMatches = array(
    'a', 'ano', 'true', 'yes', 'y', '1'
  );
  if (in_array(strtolower($str), $trueMatches))
    return true;
  else
    return false;
}

function IsTimestamp($var) {
  if (!(is_int($var) || is_float($var)))
    return false;
  return true;
}

function validateDate($date, $format = DATE_FORMAT) {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validateDateTime($date, $format = DATE_TIME_FORMAT) {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

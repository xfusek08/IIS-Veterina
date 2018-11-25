<?php

function BoolTo01Str($var) {
  if (boolval($var))
    return '1';
  else
    return '0';
}

function Str01ToBoolInt($var) {
  if ($var === '1')
    return 1;
  else if ($var === '0')
    return 0;
  return null;
}

function BoolTo01($var) {
  if (boolval($var))
    return 1;
  else
    return 0;
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

<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

function getbykeyvalue($products, $field, $value, $column) {
  foreach ($products as $key => $product) {
    if ($product[$field] === $value) {

      return $product[$column];
    }
  }
  return 0;
}

function objecttoarray($obj) {
  return json_decode(json_encode($obj), true);
}

function count_variable($cnt) {
  if (empty($cnt) || $cnt === NULL || $cnt === FALSE) {
    return 0;
  }

  if (!empty($cnt)) {
    if (is_array($cnt)) {
      return count($cnt);
    } else if (is_object($cnt)) {
      return count((array) $cnt);
    } else {
      return 1;
    }
  }
}

function implode_associative_array(array $input) {
  $output = implode(', ', array_map(
    function ($v, $k) {
      if (is_array($v)) {
        return $k . '[]=' . implode('&' . $k . '[]=', $v);
      } else {
        return $k . '=' . $v;
      }
    },
    $input,
    array_keys($input)
  ));

  return $output;
}

function array_flatten($array) {
  if (!is_array($array)) {
    return [];
  }
  $result = array();
  foreach ($array as $key => $value) {
    if (is_array($value)) {
      $result = array_merge($result, array_flatten($value));
    } else {
      $result[$key] = $value;
    }
  }
  return $result;
}

function compareByTimeStamp($time1, $time2) {
  $exp1 = explode("-", $time1);
  $exp2 = explode("-", $time2);

  if (strtotime($exp1[0]) < strtotime($exp2[0])) {
    return -1;
  } else if (strtotime($exp1[0]) > strtotime($exp2[0])) {
    return 1;
  } else {
    return 0;
  }

}

// for usort
function time_compare($a, $b) {
  $t1 = strtotime($a['time']);
  $t2 = strtotime($b['time']);
  return $t1 - $t2;
}

function compareByTimeStamp1($time1, $time2) {
                if (strtotime($time1) > strtotime($time2)) {
                    return 1;
                } else if (strtotime($time1) < strtotime($time2)) {
                    return -1;
                } else {
                    return 0;
                }

            }
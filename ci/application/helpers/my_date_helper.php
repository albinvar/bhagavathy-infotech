<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function get_updated_on() {
    return date('Y-m-d H:i');
}

function get_time_24($time) {
    return $time ? date('H:i', strtotime($time)) : null;
}

function get_time_12($time) {
    return date('h:i', strtotime($time));
}

function convert_to_mysqldatetime($date) {
    return (int) $date ? date('H:i:s', strtotime($date)) : 'N/A';
}

function convert_to_mysqldate($date) {
    return (int) $date ? date('Y-m-d', strtotime($date)) : 'N/A';
}

function get_date($date) {
    return (int) $date ? date('d-M-Y', strtotime($date)) : 'N/A';
}

function show_date($date) {
    return date('d-M-Y H:i', strtotime($date));
}

function mysql_date($date) {
    return date('Y-m-d H:i', strtotime($date));
}

function current_date() {
    return date('d-M-Y');
}

function current_date_mysqlformat() {
    return date('Y-m-d');
}
function timedifference($pretime) {
    $prevtime   = str_replace("%20", " ", $pretime);
    $currnttime = date('Y-m-d H:i:s');
    $difference = abs(strtotime($currnttime) - strtotime($prevtime));
    $hours      = abs(floor(($difference) / 3600));
    $mins       = abs(floor(($difference - ($hours * 3600)) / 60)); #floor($difference / 60);
    $secs       = abs(floor(($difference - ($hours * 3600) - ($mins * 60))));

    $duration = $hours . "-" . $mins . "-" . $secs;

    return $duration;
}

function createDateRangeArray($strDateFrom, $strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo   = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function time_travelled(array $timeslot = []) {
    $min_time      = -1;
    $max_time      = -1;
    $total_minutes = 0;

    foreach ($timeslot as $slot) {
        list($start_time, $end_time) = explode("-", $slot);

        $start_time = explode(":", $start_time);
        $start_time = intval($start_time[0]) * 60 + intval($start_time[1]); // converting to minutes
        $end_time   = explode(":", $end_time);
        $end_time   = intval($end_time[0]) * 60 + intval($end_time[1]); // converting to minutes

        if ($min_time == -1) {
// or max time for that matter (just basic initialization of these 2 variables)
            $min_time = $start_time;
            $max_time = $end_time;
            $total_minutes += $max_time - $min_time;
        } else {
            if ($start_time >= $max_time) {
                $total_minutes += $end_time - $start_time;
            } else if ($start_time < $max_time && $end_time > $max_time) {
                $total_minutes += $end_time - $max_time;
            }

            $min_time = min($min_time, $start_time);
            $max_time = max($max_time, $end_time);
        }
    }

    return $total_minutes;
}


function minutes_to_array($total_minutes) {
    return intval($total_minutes / 60) . ":" . ($total_minutes % 60) . " hrs";
}

/**
 * @param  array $time
 * @return [string]
 */
function array_total_time($time = []) {
    $time_in_secs = array_map(function ($v) {return strtotime($v) - strtotime('00:00');}, $time);
    $total_time = array_sum($time_in_secs);
    $hours      = floor($total_time / 3600);
    $minutes    = floor(($total_time % 3600) / 60);
    $seconds    = $total_time % 60;
    return str_pad($hours, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ":" . str_pad($seconds, 2, '0', STR_PAD_LEFT);
}

/**
 * [time_elapsed_string get time difference with current time in 
 * 4 hours ago, 
 * 4 months, 2 weeks, 3 days, 1 hour, 49 minutes, 15 seconds ago formats]
 * https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
 * @param  [type]  $datetime [description]
 * @param  boolean $full     [description]
 * @return [type]            [description]
 */
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// https://stackoverflow.com/questions/676824/how-to-calculate-the-difference-between-two-dates-using-php
function date_difference($date1, $date2) {
    $date1 = new DateTime($date1);
$date2 = new DateTime($date2); // date 2 should be greater
$interval = $date1->diff($date2);
return $interval;
}
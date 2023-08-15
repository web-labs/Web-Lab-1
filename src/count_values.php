<?php

    $start_time = microtime(true);
    function circle($x, $y, $r) {
        return (($x ** 2 + $y ** 2) <= ($r / 2) ** 2);
    }

    function vector ($x1, $y1, $x2, $y2){
        return $x1 * $y2 - $y1 * $x2;
    }

    function triangle ($x, $y, $r){
        $p = vector(0-$x, 0-$y, $r/2, 0);
        $q = vector($r/2-$x, 0-$y, 0-$r/2, $r-0);
        $v_r = vector(0-$x, $r-$y, 0, 0-$r);

        return (($p <= 0 && $q <= 0 && $v_r <= 0) || ($p >= 0 && $q >= 0 && $v_r >= 0));
    }

    function rectangle($x, $y, $r){
        return ($x >= 0 && $x <= $r/2 && $y <= 0 && $y >= -4);
    }

    function check_quarter($x, $y){
        if ($x > 0 && $y > 0){
            return 'first';
        } else if ($x < 0 && $y > 0){
            return 'second';
        } else if ($x < 0 && $y < 0) {
            return 'third';
        } else if ($x > 0 && $y < 0){
            return 'fourth';
        } else {
            return 'on axis';
        }
    }

    function check_axis($x, $y, $r){
        if ($x == 0 && $y > 0){
            return 'In';
        } else if ($x == 0 && $y < 0){
            return 'In';
        } else if ($y == 0 && $x < 0){
            return ($x >= $r / 2 ? 'In' : 'Out');
        } else if ($y == 0 && $x > 0){
            return ($x <= $r / 2 ? 'In' : 'Out');
        }
        return 'Absolute zero';
    }


    $x = $_POST['xVal'];
    $y = $_POST['yVal'];
    $r = $_POST['rVal'];

$response = [];

switch (check_quarter($x, $y)){
    case 'first':
        if (triangle($x, $y, $r)){
            $response['result'] = 'In';
        } else {
            $response['result'] = 'Out';
        }
        break;
    case 'second':
        $response['result'] = 'Out';
        break;
    case 'third':
        if (circle($x, $y, $r)){
            $response['result'] = 'In';
        } else {
            $response['result'] = 'Out';
        }
        break;
    case 'fourth':
        if (rectangle($x, $y, $r)){
            $response['result'] = 'In';
        } else {
            $response['result'] = 'Out';
        }
        break;
    case 'on axis':
        $response['result'] = check_axis($x, $y, $r);
        break;
}
$end_time = microtime(true);
$execution_time = ($end_time - $start_time);

date_default_timezone_set('Europe/Moscow');
$response['curr_time'] = date('H:i:s');
$response['exec_time'] = $execution_time;

header('Content-Type: application/json');
echo json_encode($response);





<?php

require __DIR__ . '/vendor/autoload.php';

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

$ip = getenv('MCQ_IP');
if (empty($ip)) {
    throw new Exception('MCQ_IP var not defined.');
}

// Set default port if not defined.
$port = getenv('MCQ_PORT') ? getenv('MCQ_PORT') : 19132;

// Set default connection method to Bedrock if not defined.
$method = 'ConnectBedrock';
if (getenv('MCQ_TYPE') == 'JAVA') {
    $method = 'Connect';
}

$Query = new MinecraftQuery();
try {
    $Query->$method($ip, $port);
    json_response($Query->GetInfo());
}
catch(MinecraftQueryException $e) {
    json_response(['error' => $e->getMessage()], 500);
}

function json_response(Array $data, int $code = 200) {

    global $ip, $port, $method;

    http_response_code($code);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');

    $data['status_code'] = $code;
    $data['ip'] = $ip;
    $data['port'] = $port;
    $data['method'] = $method;

    $data = array_change_key_case($data, CASE_LOWER);
    ksort($data);

    echo json_encode($data);
}

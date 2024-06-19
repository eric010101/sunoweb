<?php

$base_url = 'http://localhost:3000';

function make_get_request($url) {
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'GET',
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

function get_audio_information($audio_ids) {
    global $base_url;
    $url = "$base_url/api/get?ids=$audio_ids";
    return make_get_request($url);
}

if (isset($_GET['ids'])) {
    $ids = $_GET['ids'];
    $data = get_audio_information($ids);
    $response = array(
        "status" => $data[0]["status"]
    );

    if ($data[0]["status"] == 'streaming') {
        $response["audio_urls"] = array($data[0]['audio_url'], $data[1]['audio_url']);
    }

    echo json_encode($response);
}
?>

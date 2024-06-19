<?php

$base_url = 'http://localhost:3000';

function make_post_request($url, $payload) {
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($payload),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

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

function generate_audio_by_prompt($payload) {
    global $base_url;
    $url = "$base_url/api/generate";
    return make_post_request($url, $payload);
}

function get_audio_information($audio_ids) {
    global $base_url;
    $url = "$base_url/api/get?ids=$audio_ids";
    return make_get_request($url);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prompt = $_POST['prompt'];
    $make_instrumental = isset($_POST['make_instrumental']) ? true : false;
    $wait_audio = isset($_POST['wait_audio']) ? true : false;

    $payload = array(
        "prompt" => $prompt,
        "make_instrumental" => $make_instrumental,
        "wait_audio" => $wait_audio
    );

    $data = generate_audio_by_prompt($payload);

    $ids = $data[0]['id'] . ',' . $data[1]['id'];
    echo "ids: $ids<br>";

    for ($i = 0; $i < 60; $i++) {
        $data = get_audio_information($ids);
        if ($data[0]["status"] == 'streaming') {
            echo "<a href='" . $data[0]['audio_url'] . "'>Download " . $data[0]['id'] . "</a><br>";
            echo "<a href='" . $data[1]['audio_url'] . "'>Download " . $data[1]['id'] . "</a><br>";
            // Redirect to music_list.php
            header("Location: music_list.php");
            exit();
        }
        // sleep 5s
        sleep(5);
    }
}
?>

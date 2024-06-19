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
    if ($result === FALSE) {
        return null;
    }
    return json_decode($result, true);
}

function get_all_music() {
    global $base_url;
    $url = "$base_url/api/get";
    return make_get_request($url);
}

function get_clip_info($clip_id) {
    global $base_url;
    $url = "$base_url/api/clip?id=$clip_id";
    return make_get_request($url);
}

$music_data = get_all_music();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Music with Clips</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>All Music with Clips</h1>
    <?php if ($music_data): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Audio URL</th>
                <th>Clip Information</th>
            </tr>
            <?php foreach ($music_data as $music): ?>
                <?php
                    $clip_info = isset($music['clip_id']) ? get_clip_info($music['clip_id']) : null;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($music['id']); ?></td>
                    <td><?php echo htmlspecialchars($music['title'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($music['status']); ?></td>
                    <td>
                        <?php if (isset($music['audio_url'])): ?>
                            <a href="<?php echo htmlspecialchars($music['audio_url']); ?>" target="_blank">Listen</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($clip_info): ?>
                            <pre><?php echo htmlspecialchars(json_encode($clip_info, JSON_PRETTY_PRINT)); ?></pre>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No music found.</p>
    <?php endif; ?>
</body>
</html>

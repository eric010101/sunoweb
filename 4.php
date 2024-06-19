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

$music_data = get_all_music();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Music</title>
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
    <h1>AI 私人助理的音樂庫 All Music</h1>
    <?php if ($music_data): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Audio URL</th>
                <th>Video URL</th>
            </tr>
            <?php foreach ($music_data as $music): ?>
                <tr>
                    <td><?php echo htmlspecialchars($music['id']); ?></td>
                    <td><?php echo htmlspecialchars($music['title'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($music['status']); ?></td>
                    <td>
                        <?php if (isset($music['audio_url'])): ?>
                            <a href="<?php echo htmlspecialchars($music['audio_url']); ?>" target="_blank">Listen</a><br>
                            <audio controls src="<?php echo htmlspecialchars($music['audio_url']); ?>"></audio>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($music['video_url'])): ?>
                            <a href="<?php echo htmlspecialchars($music['video_url']); ?>" target="_blank">Download Video</a><br>
                            <video controls width="300">
                                <source src="<?php echo htmlspecialchars($music['video_url']); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
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

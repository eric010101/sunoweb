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
    <title>AI 私人助理的音樂庫 All Music</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #ccc;
                margin-bottom: 5px;
            }
            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <h1>AI 私人助理的音樂庫 All Music</h1>
    <?php if ($music_data): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Audio URL</th>
                    <th>Video URL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($music_data as $music): ?>
                    <tr>
                        <td data-label="ID"><?php echo htmlspecialchars($music['id']); ?></td>
                        <td data-label="Title"><?php echo htmlspecialchars($music['title'] ?? 'N/A'); ?></td>
                        <td data-label="Status"><?php echo htmlspecialchars($music['status']); ?></td>
                        <td data-label="Audio URL">
                            <?php if (isset($music['audio_url'])): ?>
                                <a href="<?php echo htmlspecialchars($music['audio_url']); ?>" target="_blank">Listen</a><br>
                                <audio controls src="<?php echo htmlspecialchars($music['audio_url']); ?>"></audio>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td data-label="Video URL">
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
            </tbody>
        </table>
    <?php else: ?>
        <p>No music found.</p>
    <?php endif; ?>
</body>
</html>

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
    <title>AI 私人助理音樂庫</title>
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
        .music-item {
            background-color: #fff;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .music-item h2 {
            margin-top: 0;
        }
        .music-item p {
            margin: 5px 0;
        }
        .music-item a {
            color: #0066cc;
            text-decoration: none;
        }
        .music-item a:hover {
            text-decoration: underline;
        }
        audio, video {
            display: block;
            margin-top: 10px;
            width: 100%;
            max-width: 600px;
        }
        @media (max-width: 600px) {
            .music-item {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>AI 私人助理音樂庫</h1>
    <?php if ($music_data): ?>
        <?php foreach ($music_data as $music): ?>
            <div class="music-item">
                <h2>ID: <?php echo htmlspecialchars($music['id']); ?></h2>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($music['title'] ?? 'N/A'); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($music['status']); ?></p>
                <p><strong>Audio URL:</strong>
                    <?php if (isset($music['audio_url'])): ?>
                        <a href="<?php echo htmlspecialchars($music['audio_url']); ?>" target="_blank">Listen</a>
                        <audio controls src="<?php echo htmlspecialchars($music['audio_url']); ?>"></audio>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </p>
                <p><strong>Video URL:</strong>
                    <?php if (isset($music['video_url'])): ?>
                        <a href="<?php echo htmlspecialchars($music['video_url']); ?>" target="_blank">Download Video</a>
                        <video controls>
                            <source src="<?php echo htmlspecialchars($music['video_url']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </p>
                <p><strong>Lyric:</strong><br>
                    <?php echo nl2br(htmlspecialchars($music['lyric'] ?? 'N/A')); ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No music found.</p>
    <?php endif; ?>
</body>
</html>

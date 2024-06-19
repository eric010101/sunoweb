<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Music</title>
    <script>
        function checkStatus(ids) {
            const statusElement = document.getElementById('status');
            const resultElement = document.getElementById('result');
            let intervalId = setInterval(async function() {
                const response = await fetch(`check_status.php?ids=${ids}`);
                const data = await response.json();
                statusElement.innerText = "Generating audio, please wait...";
                if (data.status === 'streaming') {
                    resultElement.innerHTML = `
                        <a href="${data.audio_urls[0]}">Download Audio 1</a><br>
                        <audio controls src="${data.audio_urls[0]}"></audio><br>
                        <a href="${data.audio_urls[1]}">Download Audio 2</a><br>
                        <audio controls src="${data.audio_urls[1]}"></audio>`;
                    clearInterval(intervalId);
                }
            }, 5000);
        }
    </script>
</head>
<body>
    <h1>Generate Music</h1>
    <form action="generate.php" method="post">
        <label for="prompt">Prompt:</label><br>
        <textarea id="prompt" name="prompt" rows="5" cols="100" required></textarea><br><br>

        <label for="make_instrumental">Make Instrumental:</label><br>
        <input type="checkbox" id="make_instrumental" name="make_instrumental"><br><br>

        <label for="wait_audio">Wait Audio:</label><br>
        <input type="checkbox" id="wait_audio" name="wait_audio"><br><br>

        <input type="submit" value="Generate">
    </form>
    <div id="status"></div>
    <div id="result"></div>
</body>
</html>

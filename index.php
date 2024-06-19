<?php
// 从文件中读取提示词、艺术家和音乐风格
function readFileLines($filename) {
    return file($filename, FILE_IGNORE_NEW_LINES);
}

$prompts = readFileLines('rnd_prompt.txt');
$artists_lines = readFileLines('artist.txt');
$styles = readFileLines('style.txt');

// 处理艺术家文件内容，只保留描述部分
$artists = [];
$artist_descriptions = [];

foreach ($artists_lines as $line) {
    if (preg_match('/：(.*)/', $line, $matches)) {
        $artist_descriptions[] = $matches[1];
        $artists[] = trim($line);
    }
}

// 随机选择一个提示词
$random_prompt = $prompts[array_rand($prompts)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI 私人助理音乐创作坊</title>
    <style>
        body {
            background-image: url('background.png'); /* 确保文件路径正确 */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 500px;
        }
        select, input[type="text"], input[type="submit"], textarea, button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.6); /* 半透明背景 */
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
        @media only screen and (max-width: 600px) {
            body {
                background-size: cover;
                flex-direction: column;
                padding: 10px;
            }
            .container {
                width: 100%;
                padding: 15px;
                box-shadow: none;
            }
            .button-group {
                flex-direction: column;
            }
            .button-group button,
            .button-group input[type="submit"] {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
    <script>
        const prompts = <?php echo json_encode($prompts); ?>;
        const artists = <?php echo json_encode($artists); ?>;
        const artistDescriptions = <?php echo json_encode($artist_descriptions); ?>;
        const styles = <?php echo json_encode($styles); ?>;

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

        function combinePrompt() {
            const artistSelect = document.getElementById('artist');
            const artist = artistDescriptions[artistSelect.selectedIndex - 1]; // 忽略第一个"随机"选项
            const style = document.getElementById('style').value;
            const prompt = document.getElementById('prompt').value;

            if (prompt.length > 80) {
                alert("Prompt总长不能超过80字");
                return false;
            }

            const combinedPrompt = `song: ${prompt}, art: ${artist}, style: ${style}`;
            document.getElementById('combinedPrompt').value = combinedPrompt;
            return combinedPrompt;
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            const combinedPrompt = combinePrompt();
            if (combinedPrompt) {
                if (confirm(`每次生成音乐将会创作两首音乐，收费10元RMB，每个月您有3次免费创作额度。\n\n按确定后，您将被导引到Music list页面，如果您的音乐还没出现，请在5秒后按”更新reload”，即会看到。生成完整创作需要30-60秒，请耐心等待。\n\n您确定要生成音乐吗？\n\n${combinedPrompt}`)) {
                    const form = event.target;
                    const formData = new FormData(form);

                    // Send form data to generate.php
                    fetch('generate.php', {
                        method: 'POST',
                        body: formData
                    });

                    // Immediately redirect to music_list.php
                    window.location.href = 'music_list.php';
                }
            }
        }

        function setRandomPrompt() {
            const randomPrompt = prompts[Math.floor(Math.random() * prompts.length)];
            document.getElementById('prompt').value = randomPrompt;
        }
    </script>
</head>
<body>

<div class="container">
    <h1>选择您喜欢的音乐风格</h1>
    <form onsubmit="handleFormSubmit(event)">
        <label for="artist">选择一个艺术家:</label>
        <select name="artist" id="artist">
            <option value="A:A">随机</option>
            <?php foreach ($artists as $artist): ?>
                <option value="<?php echo htmlspecialchars($artist); ?>"><?php echo htmlspecialchars($artist); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="style">选择风格:</label>
        <select name="style" id="style">
            <option value=" ">随机</option>
            <?php foreach ($styles as $style): ?>
                <option value="<?php echo htmlspecialchars($style); ?>"><?php echo htmlspecialchars($style); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="prompt" onclick="setRandomPrompt()">输入创意词Prompt<50字: 按我有惊喜<br><br></label>
        <textarea id="prompt" name="prompt" rows="5" cols="100" required><?php echo htmlspecialchars($random_prompt); ?></textarea>
        <input type="hidden" id="combinedPrompt" name="combinedPrompt">
        <br><br>
        <label for="make_instrumental">纯音乐Make Instrumental:</label>
        <input type="checkbox" id="make_instrumental" name="make_instrumental">
        <br><br>
        <label for="wait_audio">等待音乐完成Wait Audio:</label>
        <input type="checkbox" id="wait_audio" name="wait_audio">
        <br><br>
        <div class="button-group">
            <input type="submit" value="创作Generate">
            <button type="button" onclick="window.location.href='music_list.php'">音乐库List</button>
        </div>
    </form>
    <div id="status"></div>
    <div id="result"></div>
</div>

</body>
</html>

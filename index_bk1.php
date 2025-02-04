<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音乐风格选择器</title>
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
        select, input[type="text"], input[type="submit"], textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.6); /* 半透明背景 */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
        }
    </style>
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

        function combinePrompt() {
            const artist = document.getElementById('artist').value;
            const style = document.getElementById('style').value;
            const prompt = document.getElementById('prompt').value;

            if (prompt.length > 50) {
                alert("Prompt不能超过50字");
                return false;
            }

            const combinedPrompt = `描述: ${prompt}, 艺术家: ${artist}, 风格: ${style}`;
            document.getElementById('combinedPrompt').value = combinedPrompt;
            return combinedPrompt;
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            const combinedPrompt = combinePrompt();
            if (combinedPrompt) {
                if (confirm(`您确定要生成音乐吗？\n\n${combinedPrompt}`)) {
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
    </script>
</head>
<body>

<div class="container">
    <h1>选择您喜欢的音乐风格</h1>
    <form onsubmit="handleFormSubmit(event)">
        <label for="artist">选择一个艺术家:</label>
        <select name="artist" id="artist">
            <option value=" ">随机</option>
            <option value="德雷克">德雷克</option>
            <option value="肯德里克·拉马尔">肯德里克·拉马尔</option>
            <option value="女神卡卡">女神卡卡</option>
            <option value="蕾哈娜">蕾哈娜</option>
            <option value="贾斯汀·比伯">贾斯汀·比伯</option>
        </select>
        <br><br>
        <label for="style">选择风格:</label>
        <select name="style" id="style">
            <option value=" ">随机</option>
            <option value="嘻哈">嘻哈：强烈的节奏和押韵的歌词，通常包含说唱。</option>
            <option value="放克">放克：以复杂的节奏和强烈的低音线为特征，常用于舞曲。</option>
            <option value="新古典">新古典：融合古典音乐和现代元素，常用于电影配乐。</option>
            <option value="节奏布鲁斯">节奏布鲁斯：结合了灵魂和流行音乐，具有强烈的节奏感。</option>
            <option value="车库摇滚">车库摇滚：带有原始和粗糙的声音，常见于地下乐队。</option>
        </select>
        <br><br>
        <label for="prompt">输入作曲提示词Prompt<50字:</label>
        <textarea id="prompt" name="prompt" rows="5" cols="100" required></textarea>
        <input type="hidden" id="combinedPrompt" name="combinedPrompt">
        <br><br>
        <label for="make_instrumental">纯音乐Make Instrumental:</label>
        <input type="checkbox" id="make_instrumental" name="make_instrumental">
        <br><br>
        <label for="wait_audio">等待音乐完成Wait Audio:</label>
        <input type="checkbox" id="wait_audio" name="wait_audio">
        <br><br>
        <input type="submit" value="创作Generate">
    </form>
    <div id="status"></div>
    <div id="result"></div>
</div>

</body>
</html>

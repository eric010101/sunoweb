import requests

# replace your vercel domain
base_url = 'http://localhost:3000'

def get_all_music():
    url = f"{base_url}/api/get"
    response = requests.get(url)
    return response.json()

def get_clip(clip_id):
    url = f"{base_url}/api/clip?id={clip_id}"
    response = requests.get(url)
    return response.json()

if __name__ == '__main__':
    # 获取所有音乐信息
    all_music = get_all_music()

    if not all_music:
        print("No music found.")
    else:
        for music in all_music:
            music_id = music.get('id')
            title = music.get('title', 'N/A')
            status = music.get('status', 'N/A')
            audio_url = music.get('audio_url', 'N/A')

            print(f"ID: {music_id}")
            print(f"Title: {title}")
            print(f"Status: {status}")
            print(f"Audio URL: {audio_url}")

            # 获取并打印剪辑信息
            clip_id = music.get('clip_id')
            if clip_id:
                clip_info = get_clip(clip_id)
                print(f"Clip Info: {clip_info}")
            else:
                print("Clip Info: N/A")

            print("\n" + "-"*40 + "\n")

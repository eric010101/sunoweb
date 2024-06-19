import time
import requests

# replace your vercel domain
base_url = 'http://localhost:3000'


def custom_generate_audio(payload):
    url = f"{base_url}/api/custom_generate"
    response = requests.post(url, json=payload, headers={'Content-Type': 'application/json'})
    return response.json()


def extend_audio(payload):
    url = f"{base_url}/api/extend_audio"
    response = requests.post(url, json=payload, headers={'Content-Type': 'application/json'})
    return response.json()

def generate_audio_by_prompt(payload):
    url = f"{base_url}/api/generate"
    response = requests.post(url, json=payload, headers={'Content-Type': 'application/json'})
    return response.json()


def get_audio_information(audio_ids):
    url = f"{base_url}/api/get?ids={audio_ids}"
    response = requests.get(url)
    return response.json()


def get_quota_information():
    url = f"{base_url}/api/get_limit"
    response = requests.get(url)
    return response.json()

def get_clip(clip_id):
    url = f"{base_url}/api/clip?id={clip_id}"
    response = requests.get(url)
    return response.json()

def generate_whole_song(clip_id):
    payload = {"clip_id": clip_id}  # 修正拼写错误
    url = f"{base_url}/api/concat"
    response = requests.post(url, json=payload)
    return response.json()


if __name__ == '__main__':
    ids = '0f8e06a3-d7f5-4cd7-8a58-cdad2f477a03'
    print(f"ids: {ids}")

    data = get_audio_information(ids)
    
    with open('song.txt', 'w', encoding='utf-8') as file:
        for i, item in enumerate(data):
            file.write(f"Item {i+1}:\n")
            for key, value in item.items():
                file.write(f"{key}: {value}\n")
            file.write("\n")

    print("Data has been written to song.txt")

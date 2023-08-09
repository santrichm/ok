
from pyrogram import Client, filters
from pyrogram import enums

# Replace with your own API credentials
api_id = 2297604
api_hash = "3f2dda87fd4e061f826857726ad53829"
app = Client('my_session', api_id, api_hash)

@app.on_message(filters.me & filters.command("download"))
async def download_and_upload(client, message):
    if message.text and "t.me" in message.text:  # Check if the message contains a link
        try:
            link = message.text.split(" ")[1]
            url_parts = link.split('/')

            # Extract the channel ID and message ID
            channel_id = f"-100{url_parts[-2]}"
            message_id = url_parts[-1]
            print(channel_id)

            k = await app.get_messages(int(channel_id), int(message_id))
            print(k)

            media_type = k.media
            print(media_type)
            if media_type == enums.MessageMediaType.PHOTO:
                
                s = k.photo.file_id
                o= await client.download_media(s)
                await app.send_photo('me', o)
            elif media_type == enums.MessageMediaType.VIDEO:
                s = k.video.file_id
                o= await client.download_media(s)
                await app.send_video('me', o)
            elif media_type == enums.MessageMediaType.AUDIO:
                
                s = k.audio.file_id
                o= await client.download_media(s)
                await app.send_audio('me', o)
            else:
                s = k.document.file_id
                o= await client.download_media(s)
                await app.send_document('me', o)
            print(s)
            

        except Exception as e:
            print(f"An error occurred: {e}")

app.run()

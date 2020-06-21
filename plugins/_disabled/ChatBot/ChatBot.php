<?php
/**
 * This plugin sends all chat messages to Codename: Clippy and responds accordingly.
 * Learn more at https://playground.hell.sh/codename-clippy/
 *
 * @var Plugin $this
 */
use Asyncore\Asyncore;
use Phpcraft\
{Event\ClientPacketEvent, Plugin};
$this->on(function(ClientPacketEvent $event)
{
	if(!$event->cancelled && $event->packetId->name == "clientbound_chat_message")
	{
		$read_buffer_offset = $event->server->read_buffer_offset;
		$chat = $event->server->readChat();
		if($chat->with && $chat->translate === "chat.type.text" && $chat->with[0]->text != $event->server->username)
		{
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => "https://playground.hell.sh/codename-clippy/talk",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => "message=".rawurlencode($chat->with[1]->text)
			]);
			if(Asyncore::isWindows())
			{
				curl_setopt($ch, CURLOPT_CAINFO, __DIR__."/cacert.pem");
			}
			Asyncore::curl_exec($ch, function($data) use (&$event, &$chat)
			{
				$data = json_decode($data, true);
				$response = $chat->with[0]->text.": ".$data["responses"]["default"];
				do
				{
					$event->server->startPacket("serverbound_chat_message");
					$event->server->writeString(substr($response, 0, 256));
					$event->server->send();
					$response = substr($response, 256);
				}
				while($response);
			});
		}
		$event->server->read_buffer_offset = $read_buffer_offset;
	}
});

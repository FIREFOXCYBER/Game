<?php

/* Telegram Bot Information
	- This bot is intended for use in private and inside a group chat.
	- The bot has seperate commands for private or group chats.
*/

/* Command for Linux terminal
curl -F "url=https://domain.com/script.php" -F "certificate=@/etc/apache2/ssl/apache.crt" https://api.telegram.org/bot<MYTOKENHERE>/setWebhook
*/

/* FOR DEBUG ONLY
https://api.telegram.org/bot150111456:AAGmfcs4QRteRl2_UCf0oN7k5yUdGJu0erA/setWebhook // Disable WebHook
https://api.telegram.org/bot150111456:AAGmfcs4QRteRl2_UCf0oN7k5yUdGJu0erA/getUpdates // Get Updates Manually
*/

/*COMMANDS

Some of these commands relate directly to the 3xA-Gaming Community.

back - Return from away status
beer - Pass a beer to random or specific user
brb - Away messages
commands - Shows a list of all commands
date - Show current date
dice - Random dice roll
goodnight -  Tell user goodnight and mark them as sleeping
help - Bot and function help
hi - Basic greeting
info - About 3xA
joint - Pass a joint to random or specific user
joke - Random joke
ping - (admin,all) - Ping services, Ping the admin for a specific service, Ping all users in the group
servers - Display 3xA game server
start - Start events
stop - Stop events
teamspeak - (info) Give info about teamspeak, Give TS info and server query details
time - Country time info
slap - Slap specific user

*/

$botToken = "<MYTOKENHERE>";
$website = "https://api.telegram.org/bot".$botToken;
 
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$isValid = True;
$isGroup = False;
$isPrivate = False;
$first = True;

$chatId = $update["message"]["chat"]["id"];
$fromUser = $update["message"]["from"]["username"];
$type = $update["message"]["chat"]["type"];
$message = $update["message"]["text"];

$commandsGeneral = array("/back","/brb","/commands","/date","/help","/info","/joint","/servers","/start","/stop","/teamspeak","/teamspeak info","/time");
$commandsPrivate = array("/ping admin","/ping all");
$commandsGroup = array("/beer","/dice","/goodnight","/hi","/joke","/slap");

if ($type == "private") {
	$isPrivate = True;
}
if ($type == "group") {
	$isGroup = True;
}

if ($isPrivate || $isGroup) {
	// GENERAL COMMANDS
	switch($message) {
		case "/back":
			sendMessage($chatId, "Welcome back!", True);
			break;
		case "/brb":
			sendMessage($chatId, "I will see you when you get /back", True);
			break;
		case "/date":
			date_default_timezone_set('America/Los_Angeles');
			sendMessage($chatId, "Im from California.\nThe Pacific Standard Timezone\n(PST) -8 GMT,\nIts ".date('D,F j, Y, h:i:s A'), True);
			break;
		case "/date America/New_York":
			date_default_timezone_set('America/New_York');
			sendMessage($chatId, date('D,F j, Y, h:i:s A'), True);
			break;
		case "/help":
			sendMessage($chatId, "Help not configured, well for you...", True);
			break;
		case "/info":
			sendMessage($chatId, "We do not strive to be the biggest, we strive to be united and offer comradery as a community. We are always looking for mature members to join our community! - 3xA-Gaming.com/About", True);
			break;
		case "/joke":
			$jokeAPI_URL = "http://tambal.azurewebsites.net/joke/random";
			$joke = file_get_contents($jokeAPI_URL);
			$joke = json_decode($joke, TRUE);
			sendMessage($chatId,$joke["joke"], True);
			break;
		case "/joke info":
			sendMessage($chatId,"Random jokes generated using tabmalAPI provided by KaiFathi on Github.com/KiaFathi/tambalAPI", True);
			break;
		case "/joint":
			sendMessage($chatId, "Oh nice choice, I will roll one up for ya.", True);
			sleep(rand(5,25));
			$jointMsgs = array(
				"Man, I gotta take a nap dude...",
				"We might have to smoke this in a bong, I can't lick the joint... My mouth is too dry!!",
				"After we smoke this, lets make some curry and drink some beers!",
				"I ran out of weed man, but you can have one of these tacos? Sorry dude...",
				"Alright here ya go, that will run you about $30.",
				"Wait, what was I doing?",
				"Wait, you have papers, right?", 
				"Ahhh nice and plump, like a good ghetto booty! Here ya go ".ucfirst($fromUser),
				"These papers you gave me are shit, this one just tore in the middle man!"
			);
			$r_joint = array_rand($jointMsgs,1);
			sendMessage($chatId,$jointMsgs[$r_joint], True);
			break;
		case "/servers":
			sendMessage($chatId, "Servers not configured, well for you...", True);
			break;
		case "/start":
			sendMessage($chatId, "I am already started, want me to begin rambling? Do you want me to ramble some?", True);
			break;
		case "/start twamp":
			sendMessage($chatId, "This chat is now Twamping, pretty hard actually.", True);
			break;
		case "/teamspeak":
			sendMessage($chatId, "3xA-Gaming hosts a Teamspeak 3 server for our community as well as any public guests. For connection info: `/teamspeak info` ", True);
			break;
		case "/teamspeak info":
			sendMessage($chatId, "[Teamspeak Connection Info]\n _ _ _ \nAddress/Hostname: TS3.3xA-Gaming.com\nPassword: 3xA (Password is case-sensitive)\n - - - \n", True);
			break;
		case "/time":
			date_default_timezone_set('America/Los_Angeles');
			sendMessage($chatId, "Im from California.\nThe Pacific Standard Timezone\n(PST) -8 GMT,\nIts ".date('D,F j, Y, h:i:s A'), True);
			break;
		default:
			$isValid = False;
	}
	// PRIVATE COMMANDS
	if ($isPrivate) {
		switch($message) {
			case "/ping":
				sendMessage($chatId, "DEBUG##PRIVATE## PING", True);
				break;
			case "/ping admin":
				sendMessage($chatId, "DEBUG##PRIVATE## PING ADMIN", True);
				break;
			case "/ping all":
				sendMessage($chatId, "DEBUG##PRIVATE## PING ALL", True);
				break;
			case (preg_match("/Ping.*/i", $message) ? true : false):
				sendMessage($chatId, "DEBUG##PRIVATE## PING MATCH", True);
				break;
		}
	}
	// GROUP COMMANDS
	if ($isGroup) {
		switch($message) {
			case "/beer":
				sendMessage($chatId, "You're buying me a beer? sounds good ... thanks ".ucfirst($fromUser), True);
				break;
			case "/dice":
				sendMessage($chatId, "DEBUG## MISSING DICE MODULE, FUCKING TWAMP....", True);
				break;
			case "/goodnight":
				sendMessage($chatId, "DEBUG## MISSING GOODNIGHT MODULE, FUCKING TWAMP....", True);
				break;
			case "/hi":
				sendMessage($chatId, "DEBUG## GREETING MODULE, FUCKING TWAMP....", True);
				break;
			case "/slap";
				sendMessage($chatId, "DEBUG## MISSING SLAP MODULE, FUCKING TWAMP....", True);
				break;
		}
	}
} else {
	print("The message is not private or group, unexpected message type!\n Message type: ".$type);
}

function invalidMessage ($chatId, $message, $type, $commandsGeneral) {
	switch($type) {
		case "group";
			if (!in_array($message,$commandsGeneral) || !in_array($message, $commandsPrivate)) {
				// If the users message is not a valid private command, nor any other type of command.
				$errorMessage = "Not one of the valid group /commands!";
				$url = $GLOBALS["website"]."/sendMessage?chat_id=".$chatId."&text=".urlencode($errorMessage);
				file_get_contents($url);
			}
		case "private";
			if (!in_array($message,$commandsGeneral) || !in_array($message, $commandsGroup)) {
				// If the users message is not a valid private command, nor any other type of command.
				$errorMessage = "Not one of the valid private /commands!";
				$url = $GLOBALS["website"]."/sendMessage?chat_id=".$chatId."&text=".urlencode($errorMessage);
				file_get_contents($url);
			}
	}
}

function sendMessage ($chatId, $message, $isValid) {
	// Checks if messages are valid and then sends then message or calls the invalidMessage function.
	if ($isValid) {
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
		file_get_contents($url);
	} else {
		invalidMessage($chatId, $message, $type, $commandsGeneral);
	}
}
?>

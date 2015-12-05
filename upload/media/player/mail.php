<?php
define('_VALID', 1);
define('_DEBUG', false);
require '../../include/config.paths.php';
require '../../include/config.db.php';
require '../../include/config.local.php';
require '../../include/function_global.php';
require '../../include/function_language.php';
require '../../include/adodb/adodb.inc.php';
require '../../include/dbconn.php';

function valid_email($email)
{
	return eregi("^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~^?])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~^?]+\\.)+[a-zA-Z]{2,4}\$", $email);
}

$video_id	= ( isset($_GET['video_id']) && is_numeric($_GET['video_id']) ) ? intval($_GET['video_id']) : NULL;
if ( isset($_POST['me']) &&
     isset($_POST['to']) &&
	 isset($_POST['message']) ) {
	
	$from		= trim($_POST['me']);
	$to			= trim($_POST['to']);
	$message	= htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
	if ( valid_email($from) && valid_email($to) ) {
		if ( $video_id ) {
			$sql	= "SELECT VID, title FROM video WHERE VID = " .$video_id. " LIMIT 1";
			$rs		= $conn->execute($sql);
			if ( $conn->Affected_Rows() === 1 ) {
				$title		= prepare_string($rs->fields['title']);
				$video_url 	= $config['BASE_URL']. '/video/' .$video_id. '/' .$title;
				$sql 		= "SELECT * FROM emailinfo WHERE email_id='player_email' LIMIT 1";
				$rs			= $conn->execute($sql);
				if ( $conn->Affected_Rows() === 1 ) {			
					require $config['BASE_DIR']. '/classes/email.class.php';
					require $config['BASE_DIR']. '/classes/file.class.php';
					
					$subject		= $rs->fields['email_subject'];
					$path			= $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
					$body			= VFile::read($path);
					$search			= array('{$site_name}', '{$video_url}', '{$message}');
					$replace		= array($config['site_name'], $video_url, $message);
					$body			= str_replace($search, $replace, $body);
					$mail       	= new VMail();
					$mail->From 	= $from;
					$mail->FromName = $from;
					$mail->Sender   = $from;
					$mail->AddReplyTo($from);
					$mail->Subject  = $subject;
					$mail->AltBody  = $body;
      				$mail->Body     = nl2br($body);
					$mail->AddAddress($to);
					$mail->Send();
				}
			}
		}
	}
}
if (defined('_DEBUG') && _DEBUG) {
echo var_dump($body). '<br>';
?>
<html>
<head>
	<title>Testing Player Email</title>
</head>
<body>
<form name="sendPlayerEmail" method="post" action="<?php echo $config['BASE_URL']; ?>/media/player/mail.php?video_id=<?php echo $video_id; ?>">
From: <input name="me" type="text" /><br />
To: <input name="to" type="text" /><br />
Message: <textarea name="message"></textarea><br />
<input type="submit" value="Send" />
</form>
</body>
</html>
<?php
}
?>

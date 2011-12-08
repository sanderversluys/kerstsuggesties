<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once('rb.php');

R::setup();

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

$family = array('Sander' => 'versluyssander@gmail.com',
				'Marijke' => 'marijkeversluys@gmail.com',
				'Freya' => 'freyaversluys@telenet.be',
				'Filip' => 'filipschouteet@telenet.be',
				'Jan' => 'janversluys@yahoo.com',
				'Martine' => 'martine.vereecken@telenet.be', 
				'Marc' => 'marc.versluys@gmail.com');

if (isset($_POST['name'])) {

	$name = $_POST['name'];
	
	if (array_key_exists($name, $family)) {
	
		$key = generatePassword(4, 1);
		$member = R::findOne('family', 'name=?', array($name));
		if (!$member) {
			$member = R::dispense('family');
			$member->name = $name;
			$member->hash = sha1($key);
			$member->suggestions = '';
			R::store($member);
		}

		foreach($family as $n => $e) {			
		
			if ($n != $name) {
				
				$to = $e;
				$from     = 'sander@niob.be';
				$replyto  = 'sander@niob.be';
				$subject  = 'Kerst suggesties';
				$message  = "Graag contact met mij opnemen. Ik wil graag meer informatie over uw producten en diensten.
				Mvg.
				Iemand
				";
				$headers  = "From: "        . $from    . "\n";
				$headers .= "Return-path: " . $from    . "\n";
				$headers .= "Reply-to: "    . $replyto . "\n";
				
				
				/*$to      = $e;
				$subject = 
				$message = 'Er worden suggesties gevraagd voor het kerst cadeau van ' . $name . '.\n\n';
				$message .= 'Geef jullie suggesties door via het formulier op http://niob.be/kerst?hash='.$member->hash.'&sleutel='.$key.'\n\n';
				$message .= 'Verlies deze link of sleutel niet want dat is de enige manier om de suggesties te kunnen raadplegen en aanpassen';*/
				
				$to = "sversluys@reference.be";

				if (mail($to, $subject, $message, $headers)) {
					echo "<p>Suggesties aan " . $n . " via mail aangevraagd!</p>";				
				} else {
					echo "<p>Suggesties aan " . $n . " aanvragen via mail mislukt!</p>";	
				}
				
				
				
			}
		
		}
		
		exit();

	}
}

if (isset($_POST['hash']) && isset($_POST['key']) && isset($_POST['suggestions'])) {

	$hash = $_POST['hash'];
	$key = $_POST['key'];
	$suggestions = $_POST['suggestions'];
	$member = R::findOne('family', 'hash=?', array($hash));
	
	if ($member) {
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $suggestions, MCRYPT_MODE_CBC, md5(md5($key))));
		$member->suggestions = $encrypted;
		R::store($member);
	}
	
	header("Location: ".$_SERVER['PHP_SELF'].'?hash='.$hash.'&sleutel='.$key);
	exit();
}

if (isset($_GET['hash']) && isset($_GET['sleutel'])) {
	$hash = $_GET['hash'];
	$key = $_GET['sleutel'];
	$member = R::findOne('family', 'hash=?', array($hash));
	
	$decrypted = '';
	if ($member->suggestions != '')
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($member->suggestions), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	
	if (!$member) {
		header("HTTP/1.0 404 Not Found");
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Suggesties</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>

<p>Kerst suggesties 2011</p>
<?php if(isset($_GET['hash']) && isset($_GET['sleutel']) && $member): ?>
<form action="<? echo $_SERVER['php_self']?>" method="post">
	<p>Suggesties voor <?php echo $member->name ?></p>
	<textarea name="suggestions" rows="10" cols="50"><?php echo $decrypted;?></textarea/>
	<input type="hidden" name="hash" value="<?php echo $_GET['hash'] ?>" />
	<input type="hidden" name="key" value="<?php echo $_GET['sleutel'] ?>" />
	<p>
		<input type="submit" value="Opslaan"/>
	</p>
</form>
<?php else: ?>
<form action="<? echo $_SERVER['php_self']?>" method="post">
	<p>Voor wie wil je suggesties vragen?</p>
	<select name="name">
		<?php foreach($family as $name => $email): ?> 
			<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
		<?php endforeach; ?>
	</select>
	<p>
		<input type="submit" value="Suggesties aanvragen"/>
	</p>
</form>
<?php endif; ?>

</body>
</html>